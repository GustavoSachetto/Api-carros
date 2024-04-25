<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Http\Request;
use App\Http\Response;
use App\Model\Entity\User;

class BasicAuth
{
    /**
     * Instância de usuário autenticado
     */
    private User $obUser;
    
    /**
     * Método responsável por checar se o usuário e senha estão preenchidos
     */
    private function checkUserAndPassword(): void
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])) {
            throw new Exception("Acesso negado! Usuário ou senha não preenchidos.", 403);
        }
    }

    /**
     * Método responsável por verificar se o usuário solicitado existe
     */
    private function verifyUserExists(): void
    {
        $obUser = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);
        if (!$obUser instanceof User) {
            throw new Exception("Acesso negado! Usuário não existente.", 403);
        }

        $this->obUser = $obUser;
    }

    /**
     * Método responsável por verificar se a senha do usuário é valida
     */
    private function verifyPassword(): void
    {
        if (!password_verify($_SERVER['PHP_AUTH_PW'], $this->obUser->password_hash)) {
            throw new Exception("Acesso negado! Usuário não autorizado.", 403);
        }
    }

    /**
     * Método responsável por retornar se o usuário foi autenticado com sucesso
     */
    private function authenticatedUser(): bool
    {
        $this->checkUserAndPassword();
        $this->verifyUserExists();
        $this->verifyPassword();

        return true;
    }

    /**
     * Método responsável por validar o acesso via HTTP BASIC AUTH
     */
    private function basicAuth(Request $request): void
    {
        if ($this->authenticatedUser()) $request->setUser($this->obUser);        
    }
    
    /**
     * Método reponsável por executar o middleware
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->basicAuth($request);

        return $next($request);
    }
}
