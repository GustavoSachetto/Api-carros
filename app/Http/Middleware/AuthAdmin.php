<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Http\Request;
use App\Http\Response;

class AuthAdmin
{
    /**
     * Método responsável por validar se o usuário tem acesso administrador
     */
    private function userAuthAdmin(Request $request): void
    {
        if ($request->getUser()->admin_access === false) {
            throw new Exception("Acesso negado! Usuário logado não tem acesso administrador.", 403);      
        }
    }

    /**
     * Método reponsável por executar o middleware
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->userAuthAdmin($request);

        return $next($request);
    }
}
