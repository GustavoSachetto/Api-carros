<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

class Queue
{
    
    /**
     * Mapeamento de middlewares
     * @var array
     */
    private static $map = [];

    /**
     * Mapeamento de middlewares que seráo carregados em todas as rotas
     * @var array
     */
    private static $default = [];

    /**
     * Fila de middlewares a serem executados
     * @var array
     */
    private $middlewares = [];

    /**
     * Função de execução do controlador
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos da função do controlador
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Método responsavel por construir a classe de fila de middlewares
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares    = array_merge(self::$default, $middlewares);
        $this->controller     = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * Método responsável por definir o mapeamento de middlewares
     * @param array $map
     * @return void
     */
    public static function setMap($map)
    {
        self::$map = $map;
    }

    /**
     * Método responsável por definir o mapeamento de middlewares padrões
     * @param array $default
     * @return void
     */
    public static function setDefault($default)
    {
        self::$default = $default;
    }

    /**
     * Método responsável por executar o próximo nível da fila de middlewares
     * @param Request $request
     * @return Response
     */
    public function next($request)
    {
        // VERIFICA SE A FILA ESTÁ VAZIA
        if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);
    
        // MIDDLEWARE
        $middleware = array_shift($this->middlewares);

        // VERIFICA O MAPEAMENTO
        if(!isset(self::$map[$middleware])) {
            throw new Exception("Problemas ao processar o middleware da requisição", 500);
        }

        // NEXT
        $queue = $this;
        $next  = function ($request) use ($queue) {
            return $queue->next($request);
        };

        // EXECUTA O MIDDLEWARE
        return (new self::$map[$middleware])->handle($request, $next);
    }
}
