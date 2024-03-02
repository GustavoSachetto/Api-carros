<?php

namespace App\Http\Middleware;

use Exception;

class Maintenance
{
    /**
     * Método responsável por verificar o status de manutenção da página
     * @return void
     */
    private function verifyStatus()
    {
        if (getenv('MAINTENANCE') == 'true') {
            throw new Exception("Página em manutenção. Tente novamente mais tarde.", 200);
        }
    }

    /**
     * Método reponsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Reponse
     */
    public function handle($request, $next)
    {
        $this->verifyStatus();

        return $next($request);
    }
}
