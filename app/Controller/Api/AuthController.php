<?php

namespace App\Controller\Api;

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
     * Método responsável por retornar um token JWT gerado
     */
    public static function get(Request $request): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkRequiredFields([
            'email'    => $vars['email'],
            'password' => $vars['password']
        ]);
        
        $obUser = EntityUser::getUserByEmail($vars['email']);

        Examiner::checkObjectExists($obUser, EntityUser::class);
        Examiner::checkUserPassword($vars['password'], $obUser);

        $payload = ['email' => $obUser->email];
        
        return ['token' => JWT::encode($payload, getenv('JWT_KEY'), 'HS256')];
    }
}
