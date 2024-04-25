<?php

namespace App\Model\Entity;

use PDOStatement;
use App\Model\DatabaseManager\Database;

class Carmodel
{
    public int $id;

    public int $brand_id;
    public string $name;

    public bool $deleted = false;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     */
    public function create(): bool
    {
        $this->id = (new Database('model'))->insert([
            'name'      => $this->name,
            'brand_id'  => $this->brand_id
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar os dados do banco com a instância atual
     */
    public function update(): bool
    {
        return (new Database('model'))->update('id = '.$this->id, [
            'name'      => $this->name,
            'brand_id'  => $this->brand_id,
            'deleted'   => $this->deleted
        ]);
    }

    /**
     * Método responsável por excluir um dado no banco com a instância atual
     */
    public function delete(): bool
    {
        return (new Database('model'))->securityDelete('id = '.$this->id);
    }

    /**
     * Método que retorna os modelos de veículo cadastrados no banco
     */
    public static function getCarmodels(
        string $where = null, 
        string $order = null, 
        string $limit = null, 
        string $fields = '*'
        ): PDOStatement
    {
        return (new Database('model'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método reponsável por retornar um modelo de veículo pelo seu id
     */
    public static function getCarmodelById(string $id): Carmodel|string
    {
        return self::getCarmodels('id = '. $id)->fetchObject(self::class);
    }
    
    /**
     * Método responsável por retornar o modelo de veículo pelo seu nome
     */
    public static function getCarmodelByNameAndId(string $name, int $brand_id): Carmodel|string
    {
        return self::getCarModels("brand_id = {$brand_id} AND name = '{$name}'")->fetchObject(self::class);
    }
}
