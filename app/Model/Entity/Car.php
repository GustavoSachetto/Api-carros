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
     * ID do tipo de combustível do veículo
     * @var integer
     */
    public $id_combustivel;

    /**
     * ID do tipo de transmissão do veículo
     * @var integer
     */
    public $id_transmissao;

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
    public $entrada_usb = false;

    /**
     * Variavel que armazena tabelas (padrões) a serem unidas na busca
     * @var array
     */
    private static $inner = [
        'modelo'      => 'veiculo.id_modelo      = modelo.id',
        'marca'       => 'modelo.id_marca        = marca.id',
        'combustivel' => 'veiculo.id_combustivel = combustivel.id',
        'transmissao' => 'veiculo.id_transmissao = transmissao.id'
    ];

    /**
     * Variavel que armazena os campos (padrões) a serem buscados
     * @var string
     */
    private static $fields = "veiculo.*, modelo.nome_modelo, modelo.id_marca,  marca.nome_marca, combustivel.nome_combustivel, transmissao.nome_transmissao";

     /**
     * Método responsavel pelo cadastro da instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {
        // INSERE O VEÍCULO NO BANCO
        $this->id = (new Database('veiculo'))->insert([
            "valor"             => $this->valor,
	        "id_modelo"         => $this->id_modelo,
            "id_combustivel"    => $this->id_combustivel,
            "id_transmissao"    => $this->id_transmissao,
	        "versao"            => $this->versao,
	        "imagem_um"         => $this->imagem_um,
	        "imagem_dois"       => $this->imagem_dois,
	        "imagem_tres"       => $this->imagem_tres,
	        "ano_producao"      => $this->ano_producao,
            "ano_lancamento"    => $this->ano_lancamento,
	        "portas"            => $this->portas,
	        "motor"             => $this->motor,
	        "carroceria"        => $this->carroceria,
	        "piloto_automatico" => $this->piloto_automatico,
	        "climatizador"      => $this->climatizador,
	        "vidro_automatico"  => $this->vidro_automatico,
	        "am_fm"             => $this->am_fm,
	        "entrada_auxiliar"  => $this->entrada_auxiliar,
	        "bluetooth"         => $this->bluetooth,
	        "cd_player"         => $this->cd_player,
	        "dvd_player"        => $this->dvd_player,
	        "leitor_mp3"        => $this->leitor_mp3
        ]);

        return true;
    }    

    /**
     * Método rensponsavel por retornar os veículos
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getCars($where = null, $order = null, $limit = null, $fields = null)
    {
        return (new Database('veiculo'))->select($where, $order, $limit, $fields ?? self::$fields, self::$inner);
    }

    /**
     * Método reponsável por retornar o veículo pelo id
     * @param integer $id
     * @return Car
     */
    public static function getCarById($id)
    {
        return self::getCars('veiculo.id = '. $id)->fetchObject(self::class);
    }
}
