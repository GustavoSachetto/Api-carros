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
    public $brand_id;

    /**
     * Nome do modelo 
     * @var string
     */
    public $name;

    /**
     * Método responsável por cadastrar a instância atual no bando de dados
     * @return void
     */
    public function create()
    {
        $this->id = (new Database('model'))->insert([
            'brand_id'    => $this->brand_id,
            'name'        => $this->name
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar a instância atual no banco de dados
     * @return boolean
     */
    public function update()
    {
        // ATUALIZA O MODELO NO BANCO
        return (new Database('model'))->update('id = '.$this->id, [
            'brand_id'    => $this->brand_id,
            'name'        => $this->name
        ]);
    }

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
        return (new Database('model'))->select($where, $order, $limit, $fields);
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

    /**
     * Método responsável por buscar um modelo de carro pelo nome e o id
     * @param string $name
     * @param integer $id
     * @return CarModel
     */
    public static function getCarModelByNameAndId($name, $id)
    {
        return self::getCarModels('brand_id = '.$id.' AND name = "'.$name.'"')->fetchObject(self::class);
    }
}
