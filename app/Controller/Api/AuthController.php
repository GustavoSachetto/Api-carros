<?php

namespace App\Controller\Api;

use Exception;
use App\Http\Request;
use Firebase\JWT\JWT;
use App\Controller\Api;
use App\Utils\Examiner;
use App\Exception\User as ExceptionUser;
use App\Model\Entity\User as EntityUser;

class AuthController extends Api
{
    /** 
     * Método responsável por definir as possíveis mensagens das exceções
    */
    private static function init(): void
    {
        Examiner::$exception = ExceptionUser::class;
    }

    /**
     * Método responsável por validar se o usuário tem acesso administrador
     */
    private static function userAuthAdmin(EntityUser $obUser): void
    {
        if ($obUser->admin_access === false) {
            throw new Exception("Acesso negado! Usuário não tem nível de acesso administrador.", 403);      
        }
    }

    /**
     * Método responsável por retornar um token JWT gerado
     */
    public static function get(Request $request): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkRequiredFields([
            'email'    => $vars['email'] ?? null,
            'password' => $vars['password'] ?? null
        ]);
        
        $obUser = EntityUser::getUserByEmail($vars['email']);

        Examiner::checkObjectExists($obUser, EntityUser::class);
        Examiner::checkUserPassword($vars['password'], $obUser);

        $payload = ['email' => $obUser->email];
        
        return ['token' => JWT::encode($payload, getenv('JWT_KEY'), 'HS256')];
    }

    /**
     * Método responsável por validar o nível de acesso do usuário
     */
    public static function validate(Request $request): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkRequiredFields([
            'email'    => $vars['email'] ?? null,
            'password' => $vars['password'] ?? null
        ]);
        
        $obUser = EntityUser::getUserByEmail($vars['email']);

        Examiner::checkObjectExists($obUser, EntityUser::class);
        Examiner::checkUserPassword($vars['password'], $obUser);
        
        self::userAuthAdmin($obUser);

        $payload = ['email' => $obUser->email];
        
        return [
            'token' => JWT::encode($payload, getenv('JWT_KEY'), 'HS256'), 
            'success' => true
        ];
    }
}
