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
    public $nome_transmissao;

    /**
     * Método responsavel pelo cadastro da instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {
        // INSERE A TRANSMISSÃO NO BANCO
        $this->id = (new Database('transmissao'))->insert([
            'nome_transmissao' => $this->nome_transmissao
        ]);

        return true;
    }

    /**
     * Método responsável por atualizar a instância atual no banco de dados
     * @return boolean
     */
    public function atualizar()
    {
        // ATUALIZA A TRANSMISSÃO NO BANCO
        return (new Database('transmissao'))->update('id = '.$this->id, [
            'nome_transmissao' => $this->nome_transmissao
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
        return (new Database('transmissao'))->select($where, $order, $limit, $fields);
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
        return self::getTransmissions('nome_transmissao = "'.$name.'"')->fetchObject(self::class);
    }
}
