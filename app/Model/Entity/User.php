<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager\Database;

class User
{
    /**
     * ID do usuário
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário
     * @var string
     */
    public $nome;

    /**
     * Email do usuário
     * @var string
     */
    public $email;

    /**
     * Senha do usuário
     * @var string
     */
    public $senha;

    /**
     * Tipo de acesso do usuário
     * @var boolean
     */
    public $acesso_admin;

    /**
     * Método responsável por buscar os usuários no banco
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('usuario'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por buscar um usuário pelo seu ID
     * @param integer $id
     * @return User
     */
    public static function getUserById($id)
    {
        return self::getUsers('id = '.$id)->fetchObject(self::class);
    }
    
    /**
     * Método responsável por buscar um usuário pelo seu E-mail
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return self::getUsers('email = '.$email)->fetchObject(self::class);
    }
}
