<?php

namespace App\Service;

use Exception;
use Firebase\JWT\JWT;
use App\Model\Entity\User;

class Auth extends Api
{
    /**
     * Método responsável por verificar se o email e senha estão preenchidos
     * @param string $email
     * @param string $password_hash
     * @return void
     */
    private static function checkEmailAndPassword($email,$password_hash)
    {
        if (!isset($email) or !isset($password_hash)) {
            throw new Exception("Os campos 'email' e 'senha' são obrigatórios", 400);
        }
    }

    /**
     * Método responsável por verificar a instância de usuário
     * @param User $obUser
     * @return void
     */
    private static function verifyUserInstanceOf($obUser)
    {
        if (!$obUser instanceof User) {
            throw new Exception("O usuário ou senha são inválidos", 400);
        }
    }

    /**
     * Método responsável por verificar se a senha do usuário é válida
     * @param string $password_hash
     * @param User $obUser
     * @return void
     */
    private static function verifyUserPassword($password_hash, $obUser)
    {
        if (!password_verify($password_hash, $obUser->password_hash)) {
            throw new Exception("O usuário ou senha são inválidos", 400);
        }
    }

    /**
     * Método responsável por gerar um token JWT
     * @param Request $request
     * @return array
     */
    public static function generateToken($request)
    {
        $postVars = $request->getPostVars();

        self::checkEmailAndPassword($postVars['email'] ?? null,$postVars['senha'] ?? null);
        
        $obUser = User::getUserByEmail($postVars['email']);

        self::verifyUserInstanceOf($obUser);
        self::verifyUserPassword($postVars['senha'],$obUser);

        $payload = ['email' => $obUser->email];
        
        return ['token' => JWT::encode($payload, getenv('JWT_KEY'), 'HS256')];
    }
}
