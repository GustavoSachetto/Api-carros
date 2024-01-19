<?php

namespace App\Service;

use Exception;
use App\Model\Entity\User as EntityUser;

class User
{
/**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @return string
     */
    private static function getUsersItens($request)
    {
        // ITENS
        $itens = [];

        // RESULTADOS DA PÁGINA
        $results = EntityUser::getUsers(null,'id ASC');

        // RENDERIZA O ITEM
        while($obUser = $results->fetchObject(EntityUser::class)) {
            $itens[] = [
                'id' => $obUser->id,
                'nome' => $obUser->nome,
                'email' => $obUser->email,
                'senha' => $obUser->senha,
                'acesso_admin' => (bool)$obUser->acesso_admin
            ];
        }

        // RETORNA OS USUÁRIOS
        return $itens;
    }

    /**
     * Método responsável por retornar os usuários cadastrados
     * @param Resquest $request
     * @return array
     */
    public static function getUsers($request)
    {
        return self::getUsersItens($request);
    }

    /**
     * Método responsável por retornar um usuário pelo seu id
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getUser($request, $id)
    {
        // VALIDA SE O ID É NUMERICO
        if (!is_numeric($id)) {
            throw new Exception("O id ".$id." não é válido.", 400);
        }    
        
        // BUSCA USUÁRIO 
        $obUser = EntityUser::getUserById($id);

        // VERIFICA SE O USUÁRIO EXISTE
        if (!$obUser instanceof EntityUser) {
            throw new Exception("O usuário ".$id." não foi encontrado.", 404);
        }

        // RETORNA O USUÁRIO
        return [
            'id'           => $obUser->id,
            'nome'         => $obUser->nome,
            'email'        => $obUser->email,
            'senha'        => $obUser->senha,
            'acesso_admin' => (bool)$obUser->acesso_admin
        ];
    }

    /**
     * Método responsável por cadastrar um novo usuário
     * @param Request $request
     * @return array
     */
    public static function setNewUser($request)
    {
        // POST VARS
        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? null;
        $email = $postVars['email'] ?? null;
        $senha = $postVars['senha'] ?? null;
        $acesso_admin = $postVars['acesso_admin'] ?? false;

        // VALIDA SE Á CAMPOS OBRIGATÓRIOS NÃO EXISTENTES
        if (!isset($nome) || !isset($email) || !isset($senha)) {
            throw new Exception("Os campos 'nome', 'email' e 'senha' são obrigatórios.", 400);
        } else if (empty($nome) || empty($email) || empty($senha)) {
            throw new Exception("Os campos 'nome', 'email' e 'senha' não podem estar vazios.", 400);
        }

        // BUSCA USUÁRIO
        $obUser = EntityUser::getUserByEmail($email);

        // VALIDA SE O EMAIL JÁ FOI CADASTRADO
        if ($obUser instanceof EntityUser) {
            throw new Exception("Usuário '".$email."' já existente.", 400);
        }

        // CADASTRA UMA NOVA INSTÂNCIA NO BANCO
        $obUser = new EntityUser;
        $obUser->nome         = $nome;
        $obUser->email        = $email;
        $obUser->senha        = password_hash($senha, PASSWORD_DEFAULT);
        $obUser->acesso_admin = $acesso_admin;
        $obUser->cadastrar();

        // RETORNA OS DETALHES DO USUÁRIO CADASTRADO
        return [
            'id'      => $obUser->id,
            'success' => true
        ];
    }
}
