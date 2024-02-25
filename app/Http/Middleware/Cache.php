<?php

namespace App\Http\Middleware;

use App\Utils\Cache\File as CacheFile;

class Cache
{
    /**
     * Variável que armazena a requisição do atual do usuário
     * @var Request
     */
    private $request;

    /**
     * Método responsável por validar se o cliente NÃO permite cache por parte do servidor
     * @return boolean
     */
    private function validateClientCache()
    {
        $headers = $this->request->getHeaders();
        if (isset($headers['Cache-Control']) and $headers['Cache-Control'] == 'no-cache') return false;
        
        return true;
    }

    /**
     * Método responsável por validar o tempo de cache no .env
     * @return boolean
     */
    private function validateCacheTime()
    {   
        if (getenv('CACHE_TIME') <= 0) return false;
        
        return true;
    }

    /**
     * Método responsável por validar o método da requisição
     * @return boolean
     */
    private function validateMethodGet()
    {
        if ($this->request->getHttpMethod() != 'GET') return false;

        return true;
    }

    /**
     * Método responsável por verificar se a requisição atual pode ser cacheda
     * @return boolean
     */
    private function isCacheable()
    {
        if (!$this->validateCacheTime() or !$this->validateMethodGet() or !$this->validateClientCache()) return false;
    
        return true;
    }

    /**
     * Método responsável por retornar a hash do cache
     * @return string
     */
    private function getHash() {
        $uri = $this->request->getRouter()->getUri();
        $queryParams = $this->request->getQueryParams();

        $uri .= !empty($queryParams) ? '?'.http_build_query($queryParams) : '';
        return rtrim('route-'.preg_replace('/[^0-9a-zA-Z]/', '-', ltrim($uri, '/')), '-');
    }

    /**
     * Método reponsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Reponse
     */
    public function handle($request, $next)
    {
        $this->request = $request;
        if (!$this->isCacheable()) return $next($request);

        $hash = $this->getHash();
        return CacheFile::getCache($hash, getenv('CACHE_TIME'), function() use($request, $next) {
            return $next($request);
        });        
    }
}
