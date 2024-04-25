<?php

namespace App\Model\Entity;

use PDOStatement;
use App\Model\DatabaseManager\Database;

class Brand
{
    public int $id;

    public string $name;

    public bool $deleted = false;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     */
    public function create(): bool
    {
        $this->id = (new Database('brand'))->insert([
            'name'  => $this->name,
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar os dados do banco com a instância atual
     */
    public function update(): bool
    {
        return (new Database('brand'))->update('id = '.$this->id, [
            'name'     => $this->name,
            'deleted'  => $this->deleted,
        ]);
    }

    /**
     * Método responsável por excluir um dado no banco com a instância atual
     */
    public function delete(): bool
    {
        return (new Database('brand'))->securityDelete('id = '.$this->id);
    }

    /**
     * Método que retorna as marcas cadastradas no banco
     */
    public static function getBrands(
        string $where = null, 
        string $order = null, 
        string $limit = null, 
        string $fields = '*'
        ): PDOStatement
    {
        return (new Database('brand'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método reponsável por retornar uma marca pelo seu ID
     */
    public static function getBrandById(string $id): Brand|string
    {
        return self::getBrands('id = '. $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar a marca pelo nome
     */
    public static function getBrandByName(string $name): Brand|string
    {
        return self::getBrands('name = "'.$name.'"')->fetchObject(self::class);
    }
}
