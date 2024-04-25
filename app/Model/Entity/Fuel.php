<?php

namespace App\Model\Entity;

use PDOStatement;
use App\Model\DatabaseManager\Database;

class Fuel
{
    public int $id;

    public string $name;

    public bool $deleted = false;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     */
    public function create(): bool
    {
        $this->id = (new Database('fuel'))->insert([
            'name'  => $this->name,
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar os dados do banco com a instância atual
     */
    public function update(): bool
    {
        return (new Database('fuel'))->update('id = '.$this->id, [
            'name'     => $this->name,
            'deleted'  => $this->deleted,
        ]);
    }

    /**
     * Método responsável por excluir um dado no banco com a instância atual
     */
    public function delete(): bool
    {
        return (new Database('fuel'))->securityDelete('id = '.$this->id);
    }

    /**
     * Método que retorna os combustíveis cadastrados no banco
     */
    public static function getFuels(
        string $where = null, 
        string $order = null, 
        string $limit = null, 
        string $fields = '*'
        ): PDOStatement
    {
        return (new Database('fuel'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método reponsável por retornar uma combustível pelo seu ID
     */
    public static function getFuelById(string $id): Fuel|string
    {
        return self::getFuels('id = '. $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar o combustível pelo nome
     */
    public static function getFuelByName(string $name): Fuel|string
    {
        return self::getFuels('name = "'.$name.'"')->fetchObject(self::class);
    }
}
