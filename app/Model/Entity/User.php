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
    public $acesso_admin = false;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {
        // INSERE O USUÁRIO NO BANCO
        $this->id = (new Database('usuario'))->insert([
            'nome'         => $this->nome,
            'email'        => $this->email,
            'senha'        => $this->senha,
            'acesso_admin' => $this->acesso_admin
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar a instância atual no banco de dados
     * @return boolean
     */
    public function atualizar()
    {
        // ATUALIZA O USUÁRIO NO BANCO
        return (new Database('usuario'))->update('id = '.$this->id, [
            'nome'         => $this->nome,
            'email'        => $this->email,
            'senha'        => $this->senha,
            'acesso_admin' => (bool)$this->acesso_admin
        ]);
    }

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
        return self::getUsers('email = "'.$email.'"')->fetchObject(self::class);
    }
}
