<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager\Database;

class Brand
{
    /**
     * ID do marca
     * @var integer
     */
    public $id;

    /**
     * Nome do marca
     * @var string
     */
    public $nome_marca;

    /**
     * Método rensponsavel por buscar as marcas
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getBrands($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('marca'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método reponsável por retornar a marca pelo id
     * @param integer $id
     * @return Brand
     */
    public static function getBrandById($id)
    {
        return self::getBrands('id = '. $id)->fetchObject(self::class);
    }
}
