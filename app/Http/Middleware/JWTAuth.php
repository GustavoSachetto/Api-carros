<?php

namespace App\Http\Middleware;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Model\Entity\User;

class JWTAuth
{
    /**
     * Método responsável por retornar o JWT (Json Web Token) decodificado
     * @param string $jwt
     * @return array
     */
    private function getJWTDecode($jwt)
    {
        try {
            return (array)JWT::decode($jwt, new Key(getenv('JWT_KEY'), 'HS256'));
        } catch (\Exception) {
            throw new Exception("Acesso negado! Token inválido.", 403);
        }
    }

    /**
     * Método responsável por retornar uma instância de usuário autenticado
     * @param Request $request
     * @return User
     */
    private function getJWTAuthUser($request)
    {
        $headers = $request->getHeaders();
        $jwt = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : '';
        
        $decode =$this->getJWTDecode($jwt);

        $email = $decode['email'] ?? '';
        $obUser = User::getUserByEmail($email);

        return $obUser instanceof User ? $obUser : false;
    }

    /**
     * Método responsável por validar o acesso via JWT
     * @param Request $request
     * @return void
     */
    private function auth($request)
    {
        if ($obUser = $this->getJWTAuthUser($request)) {
            $request->user = $obUser;
            return true;
        }

        throw new Exception("Acesso negado! Senha inválida", 403);
    }

    /**
     * Método reponsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Reponse
     */
    public function handle($request, $next)
    {
        $this->auth($request);

        return $next($request);
    }
}
