<?php

namespace App\Model\Entity;

use PDOStatement;
use App\Model\DatabaseManager\Database;

class Transmission
{
    public int $id;

    public string $name;

    public bool $deleted = false;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     */
    public function create(): bool
    {
        $this->id = (new Database('transmission'))->insert([
            'name'  => $this->name,
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar os dados do banco com a instância atual
     */
    public function update(): bool
    {
        return (new Database('transmission'))->update('id = '.$this->id, [
            'name'     => $this->name,
            'deleted'  => $this->deleted,
        ]);
    }

    /**
     * Método responsável por excluir um dado no banco com a instância atual
     */
    public function delete(): bool
    {
        return (new Database('transmission'))->securityDelete('id = '.$this->id);
    }

    /**
     * Método que retorna as transmissões cadastradas no banco
     */
    public static function getTransmissions(
        string $where = null, 
        string $order = null, 
        string $limit = null, 
        string $fields = '*'
        ): PDOStatement
    {
        return (new Database('transmission'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método reponsável por retornar uma transmissão pelo seu ID
     */
    public static function getTransmissionById(string $id): Transmission|string
    {
        return self::getTransmissions('id = '. $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar uma transmissão pelo nome
     */
    public static function getTransmissionByName(string $name): Transmission|string
    {
        return self::getTransmissions('name = "'.$name.'"')->fetchObject(self::class);
    }
}
