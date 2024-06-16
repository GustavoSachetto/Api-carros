<?php

namespace App\Controller\Api;

use App\Http\Request;
use App\Controller\Api;
use App\Utils\Examiner;
use App\Exception\User as ExceptionUser;
use App\Model\Entity\User as EntityUser;

class UserController extends Api
{
    /** 
     * Método responsável por definir as possíveis mensagens das exceções
    */
    private static function init(): void
    {
        Examiner::$exception = ExceptionUser::class;
    }

    /** 
     * Método responsável por setar os campos do usuário
    */
    private static function setUserFields(EntityUser $obUser, array $vars): void
    {
        $obUser->name          = $vars['name'] ?? $obUser->name;
        $obUser->email         = $vars['email'] ?? $obUser->email;
        $obUser->password_hash = password_hash($vars['password_hash'], PASSWORD_DEFAULT) ?? $obUser->password_hash;
        $obUser->admin_access  = $vars['admin_access'] ?? $obUser->admin_access;
        $obUser->deleted       = $vars['deleted'] ?? $obUser->deleted;
    }

    /**
     * Método responsável por retornar os usuários existentes
     */
    public static function get(): array
    {   
        $itens = [];
        $results = EntityUser::getUsers('deleted = false', 'id ASC');

        while($obUser = $results->fetchObject(EntityUser::class)) {
            $itens[] = [
                'id'           => $obUser->id,
                'name'         => $obUser->name,
                'email'        => $obUser->email,
                'admin_access' => $obUser->admin_access
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por retornar um usuário pelo seu id
     */
    public static function fetch(Request $request, int $id): array
    {           
        self::init();
        
        Examiner::checkId($id);
        $obUser = EntityUser::getUserById($id);
        Examiner::checkObjectExists($obUser, EntityUser::class);
        
        return [
            'id'            => $obUser->id,
            'name'          => $obUser->name,
            'email'         => $obUser->email,
            'admin_access'  => $obUser->admin_access,
            'password_hash' => $obUser->password_hash,
            'deleted'       => $obUser->deleted
        ];;
    }

    /**
     * Método responsável por setar um novo usuário
     */
    public static function set(Request $request): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkRequiredFields([
            'name'          => $vars['name'] ?? null, 
            'email'         => $vars['email'] ?? null, 
            'password'      => $vars['password'] ?? null
        ]);

        $obUser = EntityUser::getUserByEmail($vars['email']);
        Examiner::checkObjectNotExists($obUser, EntityUser::class);

        $obUser = new EntityUser;
        $obUser->name          = $vars['name'];
        $obUser->email         = $vars['email'];
        $obUser->password_hash = password_hash($vars['password'], PASSWORD_DEFAULT);
        $obUser->create();

        return [
            'id'      => $obUser->id,
            'success' => true
        ];
    }   
    
    /**
     * Método responsável por editar um usuário pelo seu id
     */
    public static function edit(Request $request, int $id): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkId($id);
        Examiner::checkRequiredFields([
            'name'          => $vars['name'] ?? null, 
            'email'         => $vars['email'] ?? null, 
            'password_hash' => $vars['password_hash'] ?? null
        ]);

        $obUser = EntityUser::getUserById($id);
        Examiner::checkObjectExists($obUser, EntityUser::class);

        $obUser = EntityUser::getUserByEmail($vars['email']);
        Examiner::checkDuplicateObject($obUser, EntityUser::class, $id);

        self::setUserFields($obUser, $vars);
        $obUser->update();

        return [
            'id'      => $obUser->id,
            'success' => true
        ];
    }
    
    /**
     * Método responsável por deletar um usuário pelo seu id
     */
    public static function delete(Request $request, int $id): array
    {
        self::init();

        Examiner::checkId($id);

        $obUser = EntityUser::getUserById($id);
        Examiner::checkObjectExists($obUser, EntityUser::class);
        
        $obUser->delete();

        return [
            'success' => true
        ];
    }
}
