<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager\Database;

class Fuel
{
    /**
     * ID do combustível
     * @var integer
     */
    public $id;

    /**
     * Nome do combustível
     * @var string
     */
    public $name;

    /**
     * Método responsavel pelo cadastro da instância atual no banco de dados
     * @return boolean
     */
    public function create()
    {
        $this->id = (new Database('fuel'))->insert([
            'name' => $this->name
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar a instância atual no banco de dados
     * @return boolean
     */
    public function update()
    {
        return (new Database('fuel'))->update('id = '.$this->id, [
            'name' => $this->name
        ]);
    }

    /**
     * Método rensponsavel por buscar os combustíveis
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getFuels($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('fuel'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método reponsável por retornar o combustível pelo id
     * @param integer $id
     * @return Fuel
     */
    public static function getFuelById($id)
    {
        return self::getFuels('id = '. $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por buscar um combustível pelo nome
     * @param string $name
     * @return Fuel
     */
    public static function getFuelByName($name)
    {
        return self::getFuels('name = "'.$name.'"')->fetchObject(self::class);
    }
}
