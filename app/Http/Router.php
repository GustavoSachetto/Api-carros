<?php

namespace App\Http;

use Closure;
use Exception;
use ReflectionFunction;
use App\Http\Middleware\Queue as MiddlewareQueue;

class Router
{
    /**
     * URL completa do projeto (raiz)
     * @var string
     */
    private $url= '';

    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /**
     * Índice de rotas
     * @var array
     */
    private $routes = [];

    /**
     * Instância de request
     * @var Request
     */
    private $request;

    /**
     * Content type padrão do response
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Método responsável por iniciar a classe
     * @param string $url
     * @return void
     */
    public function __construct($url)
    {
        $this->request  = new Request($this);
        $this->url      = $url;   
        $this->setPrefix();
    }

    /**
     * Método responsável por alterar o valor do content type
     * @param string $contentType
     * @return void
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * Método responsável por definir o prefixo das rotas
     * @return void
     */
    private function setPrefix()
    {
        // INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url);

        // DEFINE O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Método responsável por adicionar uma rota na classe
     * @param string $method
     * @param string $route
     * @param array @params
     * @return void
     */
    private function addRoute($method, $route, $params = [])
    {
        // VALIDAÇÃO DOS PARÂMETROS
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
            }
        }

        // MIDDLEWARES DA ROTA
        $params['middlewares'] = $params['middlewares'] ?? [];

        //VARIÁVEIS DA ROTA
        $params['variables'] = [];
        
        // PADRÃO DE VALIDAÇAO DAS VARIÁVEIS DAS ROTAS
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        // REMOVE BARRA NO FINAL DA ROTA
        $route = rtrim($route,'/');

        // PADRÃO DE VALIDAÇAO DA URL
        $patternRoute = '/^'. str_replace('/', '\/', $route) . '$/';

        // ADICIONA A ROTA DENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Método responsável por definir uma rota de GET
     * @param string $route
     * @param array @params
     * @return void
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de OPTIONS
     * @param string $route
     * @param array $params
     * @return void
     */
    public function options($route, $params = [])
    {
        return $this->addRoute('OPTIONS', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de POST
     * @param string $route
     * @param array @params
     * @return void
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de PUT
     * @param string $route
     * @param array @params
     * @return void
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de DELETE
     * @param string $route
     * @param array @params
     * @return void
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    
    /**
     * Método responsável por retornar a URI desconsiderando o prefixo
     * @return string
     */
    private function getUri()
    {
        // URI DA REQUEST
        $uri = $this->request->getUri();
        
        // FATIA A URI COM O PREFIXO
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        // RETORNA A URI SEM PREFIXO
        return rtrim(end($xUri), '/');
    }

    /**
     * Método responsável por retornar os dados da rota atual
     * @return array
     */
    private function getRoute()
    {
        // URI
        $uri = $this->getUri();

        // METHOD
        $httpMethod = $this->request->getHttpMethod();

        // VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            // VERIFICA SE A URI BATE COM O PADRÃO   
            if (preg_match($patternRoute, $uri, $matches)) {
                // VERIFICA O METODO
                if (isset($methods[$httpMethod])) {
                    // REMOVO A PRIMEIRA POSIÇÃO
                    unset($matches[0]);

                    // VARIAVEIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys,$matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;
                   
                    // RETORNO DOS PARÂMETROS DA ROTA
                    return $methods[$httpMethod];
                }
                
                // MÉTODO NÃO PERMITIDO
                throw new Exception("Método não permitido", 405);
            }
        }
        // URL NÃO ENCONTRADA
        throw new Exception("Url não encontrada", 404);
    }

    /**
     * Método responsável por executar a rota atual
     * @return Response
     */
    public function run()
    {
        try {
            // OBTÉM A ROTA ATUAL
            $route = $this->getRoute();

            // VERIFICA CONTROLADOR DA ROTA
            if (!isset($route['controller'])) {
                throw new Exception("A Url não pode ser processada", 500);
            }

            // ARGUMENTOS DA FUNÇÃO
            $args = [];

            // REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            // RETORNA A EXECUÇÃO DA FILA DE MIDDLEWARES
            return (new MiddlewareQueue($route['middlewares'],$route['controller'], $args))->next($this->request);
            
        } catch (Exception $e) {
            return new Response($e->getCode(), $this->getErrorMessage($e->getMessage()), $this->contentType);
        }
    }

    /**
     * Método responsável por retornar a mensagem de erro de acordo com o content type
     * @param string $message
     * @return mixed
     */
    private function getErrorMessage($message)
    {
        switch ($this->contentType) {
            case 'application/json':
                return [
                    'error' => $message
                ];
                break;
            default:
                return [
                    'error' => $message
                ];
                break;
        }
    }

    /**
     * Método responsavel por retornar a URL atual
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->url.$this->getUri();
    }

    /**
     * Método responsável por redirecionar a URL
     * @param string $route
     * @return void
     */
    public function redirect($route)
    {
        // URL
        $url = $this->url.$route;

        // EXECUTA O REDIRECT
        header('location: '.$url);
        exit;
    }
}
