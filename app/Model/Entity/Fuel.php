<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager\Database;

class Fuel
{
    /**
     * ID do combustível
     * @var integer
     */
    public $id;

    /**
     * Nome do combustível
     * @var string
     */
    public $nome_combustivel;

    /**
     * Método responsavel pelo cadastro da instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {
        // INSERE O COMBUSTÍVEL NO BANCO
        $this->id = (new Database('combustivel'))->insert([
            'nome_combustivel' => $this->nome_combustivel
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar a instância atual no banco de dados
     * @return boolean
     */
    public function atualizar()
    {
        // ATUALIZA O COMBUSTÍVEL NO BANCO
        return (new Database('combustivel'))->update('id = '.$this->id, [
            'nome_combustivel' => $this->nome_combustivel
        ]);
    }

    /**
     * Método rensponsavel por buscar os combustíveis
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getFuels($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('combustivel'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método reponsável por retornar o combustível pelo id
     * @param integer $id
     * @return Fuel
     */
    public static function getFuelById($id)
    {
        return self::getFuels('id = '. $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por buscar um combustível pelo nome
     * @param string $name
     * @return Fuel
     */
    public static function getFuelByName($name)
    {
        return self::getFuels('nome_combustivel = "'.$name.'"')->fetchObject(self::class);
    }
}
