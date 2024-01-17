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
    public $nome_combustivel;

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
        return (new Database('combustivel'))->select($where, $order, $limit, $fields);
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
}
