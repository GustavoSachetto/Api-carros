<?php

namespace App\Http\Middleware;

use Exception;

class Maintenance
{
    
    /**
     * Método reponsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Reponse
     */
    public function handle($request, $next)
    {
        if (getenv('MAINTENANCE') == 'true') {
            throw new Exception("Página em manutenção. Tente novamente mais tarde.", 200);
        }

        return $next($request);
    }
}
