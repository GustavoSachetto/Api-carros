<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager\Database;

class Transmission
{
    /**
     * ID da transmissão
     * @var integer
     */
    public $id;

    /**
     * Nome da transmissão
     * @var string
     */
    public $nome_transmissao;

    /**
     * Método rensponsavel por buscar as transmissões
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getTransmissions($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('transmissao'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método reponsável por retornar a transmissão pelo id
     * @param integer $id
     * @return Transmission
     */
    public static function getTransmissionById($id)
    {
        return self::getTransmissions('id = '. $id)->fetchObject(self::class);
    }
}
