<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager\Database;

class CarModel
{
    /**
     * ID do modelo
     * @var integer
     */
    public $id;

    /**
     * ID da marca relacionada ao modelo
     * @var integer
     */
    public $id_marca;

    /**
     * Nome do modelo 
     * @var string
     */
    public $nome_modelo;

    /**
     * Método responsável por retornar os modelos do veíclo
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getCarModels($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('modelo'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por buscar um modelo de carro pelo seu ID
     * @param integer $id
     * @return CarModel
     */
    public static function getCarModelById($id)
    {
        return self::getCarModels('id = '.$id)->fetchObject(self::class);
    }
}
