<?php

namespace App\Http\Middleware;

use Exception;

class AdminAuth
{
    /**
     * Método responsável por verificar se o usuário está autenticado
     * @param User $obUser
     * @return void
     */
    private function verifyUserExists($obUser)
    {
        if (!isset($obUser)) {
            throw new Exception("Acesso negado! Usuário não está logado.", 403);
        }
    }
    /**
     * Método responsável por verificar o nivel de acesso do usuário autenticado
     * @param User $obUser
     * @return void
     */
    private function verifyUserAccess($obUser)
    {
        if (!$obUser->admin_access) {
            throw new Exception("Acesso negado! Usuário não contém nivel de acesso administrador.", 403);
        }
    }

    /**
     * Método responsável por verificar o nível de acesso do usuário
     * @param Request $request
     * @return boolean
     */
    private function authenticatedAdmin($request)
    {
        $obUser = $request->user ?? null;

        $this->verifyUserExists($obUser);
        $this->verifyUserAccess($obUser);

        return true;
    }

    /**
     * Método reponsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Reponse
     */
    public function handle($request, $next)
    {
        $this->authenticatedAdmin($request);

        return $next($request);
    }
}
