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
    public $name;

    /**
     * Email do usuário
     * @var string
     */
    public $email;

    /**
     * Senha do usuário
     * @var string
     */
    public $password_hash;

    /**
     * Tipo de acesso do usuário
     * @var boolean
     */
    public $admin_access = false;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function create()
    {
        $this->id = (new Database('user'))->insert([
            'name'         => $this->name,
            'email'        => $this->email,
            'password_hash'=> $this->password_hash,
            'admin_access' => $this->admin_access
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar a instância atual no banco de dados
     * @return boolean
     */
    public function update()
    {
        return (new Database('user'))->update('id = '.$this->id, [
            'name'         => $this->name,
            'email'        => $this->email,
            'password_hash'=> $this->password_hash,
            'admin_access' => $this->admin_access
        ]);
    }

    /**
     * Método responsável por excluir a instância atual no banco de dados
     * @return boolean
     */
    public function delete()
    {
        return (new Database('user'))->delete('id = '.$this->id);
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
        return (new Database('user'))->select($where, $order, $limit, $fields);
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
