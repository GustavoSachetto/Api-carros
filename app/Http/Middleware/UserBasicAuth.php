<?php

namespace App\Http\Middleware;

use Exception;
use App\Model\Entity\User;

class UserBasicAuth
{
    /**
     * Instância de usuário autenticado
     * @var User
     */
    private $obUser;
    
    /**
     * Método responsável por checar se o usuário e senha estão preenchidos
     * @return void
     */
    private function checkUserAndPassword()
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])) {
            throw new Exception("Acesso negado! Usuário ou senha não preenchidos.", 403);
        }
    }

    /**
     * Método responsável por verificar se o usuário solicitado existe
     * @return void
     */
    private function verifyUserExists()
    {
        $obUser = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);
        if (!$obUser instanceof User) {
            throw new Exception("Acesso negado! Usuário não existente.", 403);
        }

        $this->obUser = $obUser;
    }

    /**
     * Método responsável por verificar se a senha do usuário é valida
     * @return void
     */
    private function verifyPassword()
    {
        if (!password_verify($_SERVER['PHP_AUTH_PW'], $this->obUser->password_hash)) {
            throw new Exception("Acesso negado! Usuário não autorizado.", 403);
        }
    }

    /**
     * Método responsável por retornar se o usuário foi autenticado com sucesso
     * @return boolean
     */
    private function authenticatedUser()
    {
        $this->checkUserAndPassword();
        $this->verifyUserExists();
        $this->verifyPassword();

        return true;
    }

    /**
     * Método responsável por validar o acesso via HTTP BASIC AUTH
     * @param Request $request
     * @return void
     */
    private function basicAuth($request)
    {
        if ($this->authenticatedUser()) $request->user = $this->obUser;        
    }

    /**
     * Método reponsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Reponse
     */
    public function handle($request, $next)
    {
        $this->basicAuth($request);

        return $next($request);
    }
}
