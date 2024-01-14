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
        // VERIFICA O ESTADO DE MANUTENÇÃO DA PÁGINA
        if (getenv('MAINTENANCE') == 'true') {
            throw new Exception("Página em manutenção. Tente novamente mais tarde.", 200);
        }

        // EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }
}
