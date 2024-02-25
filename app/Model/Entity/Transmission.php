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
    public $name;

    /**
     * Método responsavel pelo cadastro da instância atual no banco de dados
     * @return boolean
     */
    public function create()
    {
        $this->id = (new Database('transmission'))->insert([
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
        return (new Database('transmission'))->update('id = '.$this->id, [
            'name' => $this->name
        ]);
    }

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
        return (new Database('transmission'))->select($where, $order, $limit, $fields);
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

    /**
     * Método responsável por buscar uma transmissão pelo nome
     * @param string $name
     * @return Transission
     */
    public static function getTransmissionByName($name)
    {
        return self::getTransmissions('name = "'.$name.'"')->fetchObject(self::class);
    }
}
