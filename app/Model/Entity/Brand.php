<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager\Database;

class Brand
{
    /**
     * ID da marca
     * @var integer
     */
    public $id;

    /**
     * Nome da marca
     * @var string
     */
    public $name;

    /**
     * Método responsável pelo cadastro da instância atual no banco de dados
     * @return boolean
     */
    public function create()
    {
        $this->id = (new Database('brand'))->insert([
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
        return (new Database('brand'))->update('id = '.$this->id, [
            'name' => $this->name
        ]);
    }

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
        return (new Database('brand'))->select($where, $order, $limit, $fields);
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
    
    /**
     * Método responsável por retornar a marca pelo nome
     * @param string $name
     * @return Brand
     */
    public static function getBrandByName($name)
    {
        return self::getBrands('name = "'.$name.'"')->fetchObject(self::class);
    }
}
