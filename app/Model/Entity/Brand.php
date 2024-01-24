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
     * Método responsavel pelo cadastro da instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {
        // INSERE A MARCA NO BANCO
        $this->id = (new Database('marca'))->insert([
            'nome_marca' => $this->nome_marca
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar a instância atual no banco de dados
     * @return boolean
     */
    public function atualizar()
    {
        // ATUALIZA A MARCA NO BANCO
        return (new Database('marca'))->update('id = '.$this->id, [
            'nome_marca' => $this->nome_marca
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
    
    /**
     * Método responsável por retornar a marca pelo nome
     * @param string $name
     * @return Brand
     */
    public static function getBrandByName($name)
    {
        return self::getBrands('nome_marca = "'.$name.'"')->fetchObject(self::class);
    }
}
