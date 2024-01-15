<?php

namespace App\Model\Entity;

use App\Model\DatabaseManager\Database;

class Car
{
    /**
     * ID do veiculo
     * @var integer
     */
    public $id;

    /**
     * ID da marca do veículo
     * @var integer
     */
    public $id_marca;

    /**
     * ID do modelo do veículo
     * @var integer
     */
    public $id_modelo;

    /**
     * Valor do veículo
     * @var decimal
     */
    public $valor;

    /**
     * Marca do veículo
     * @var string
     */
    public $nome_marca;

    /**
     * Modelo do veículo
     * @var string
     */
    public $nome_modelo;

    /**
     * Versão do veículo
     * @var string
     */
    public $versao;

    /**
     * Imagem do veículo
     * @var string
     */
    public $imagem_um;

    /**
     * Imagem do veículo
     * @var string
     */
    public $imagem_dois = null;

    /**
     * Imagem do veículo
     * @var string
     */
    public $imagem_tres = null;

    /**
     * Ano de produção
     * @var string
     */
    public $ano_producao;

    /**
     * Ano de lançamento
     * @var string
     */
    public $ano_lancamento;

    /**
     * Modo de combustivel do veículo
     * @var string
     */
    public $nome_combustivel;

    /**
     * Quantidade de portas do veículo
     * @var integer
     */
    public $portas;

    /**
     * Tipo de transmissão do veículo
     * @var string
     */
    public $nome_transmissao;

    /**
     * Tipo de motor do veículo
     * @var decimal
     */
    public $motor;

    /**
     * Modelo da carroceria do veículo
     * @var string
     */
    public $carroceria;

    /**
     * Características de conforto do veículo
     * @var boolean
     */
    public $piloto_automatico = false;

    /**
     * Características de conforto do veículo
     * @var boolean
     */
    public $climatizador = false;

    /**
     * Características de conforto do veículo
     * @var boolean
     */
    public $vidro_automatico = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $am_fm = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $entrada_auxiliar = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $bluetooth = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $cd_player = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $dvd_player = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $leitor_mp3 = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $endrada_usb = false;

    /**
     * Tabelas a serem unidas na busca
     * @var array
     */
    private static $inner = [
        'modelo'      => 'veiculo.id_modelo      = modelo.id',
        'marca'       => 'modelo.id_marca        = marca.id',
        'combustivel' => 'veiculo.id_combustivel = combustivel.id',
        'transmissao' => 'veiculo.id_transmissao = transmissao.id'
    ];

    /**
     * Método rensponsavel por retornar os veículos
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getCars($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('veiculo'))->select($where, $order, $limit, $fields, self::$inner);
    }
}
