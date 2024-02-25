<?php

namespace App\Http\Middleware;

use Exception;

class UserAdminAuth
{
    /**
     * Método responsável por verificar o nível de acesso do usuário
     * @param Request $request
     * @return void
     */
    private function adminAuth($request)
    {
        // INSTANCIANDO VARIÁVEL AUXILIAR
        $obUser = $request->user;

        // VERIFICANDO SE O USUÁRIO CONTÉM O NÍVEL (ADMIN)
        if ($obUser->admin_access) {
            return true;
        }

        // ERRO DE ACESSO NEGADO
        throw new Exception("Acesso negado! Usuário não contém nivel de acesso administrador.", 403);
    }

    /**
     * Método reponsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Reponse
     */
    public function handle($request, $next)
    {
        // REALIZA A VALIDAÇÃO DO ACESSO VIA BASIC AUTH
        $this->adminAuth($request);

        // EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }
}
