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
    public $brand_id;

    /**
     * ID do modelo do veículo
     * @var integer
     */
    public $model_id;

    /**
     * ID do tipo de combustível do veículo
     * @var integer
     */
    public $fuel_id;

    /**
     * ID do tipo de transmissão do veículo
     * @var integer
     */
    public $transmission_id;

    /**
     * Valor do veículo
     * @var float
     */
    public $price;

    /**
     * Marca do veículo
     * @var string
     */
    public $brand_name;

    /**
     * Modelo do veículo
     * @var string
     */
    public $model_name;

    /**
     * Versão do veículo
     * @var string
     */
    public $version;

    /**
     * Imagem do veículo
     * @var string
     */
    public $primary_image;

    /**
     * Imagem do veículo
     * @var string
     */
    public $secondary_image = null;

    /**
     * Imagem do veículo
     * @var string
     */
    public $tertiary_image = null;

    /**
     * Ano de produção
     * @var string
     */
    public $production_year;

    /**
     * Ano de lançamento
     * @var string
     */
    public $release_year;

    /**
     * Modo de combustivel do veículo
     * @var string
     */
    public $fuel_name;

    /**
     * Quantidade de portas do veículo
     * @var integer
     */
    public $doors;

    /**
     * Tipo de transmissão do veículo
     * @var string
     */
    public $transmission_name;

    /**
     * Tipo de motor do veículo
     * @var float
     */
    public $motor;

    /**
     * Modelo da carroceria do veículo
     * @var string
     */
    public $bodywork;

    /**
     * Características de conforto do veículo
     * @var boolean
     */
    public $automatic_pilot = false;

    /**
     * Características de conforto do veículo
     * @var boolean
     */
    public $air_conditioner = false;

    /**
     * Características de conforto do veículo
     * @var boolean
     */
    public $automatic_glass = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $am_fm = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $auxiliary_input = false;

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
    public $mp3_reader = false;

    /**
     * Características de entretenimento do veículo
     * @var boolean
     */
    public $usb_port = false;

    /**
     * campo padrão a ser buscado
     * @var string
     */
    private static $fields = "vehicle.*, model.name as model_name, model.brand_id,  brand.name as brand_name, fuel.name as fuel_name, transmission.name as transmission_name";

    /**
     * Método responsavel pelo cadastro da instância atual no banco de dados
     * @return boolean
     */
    public function create()
    {
        $this->id = (new Database('vehicle'))->insert([
            "price"              => $this->price,
	        "model_id"           => $this->model_id,
            "fuel_id"            => $this->fuel_id,
            "transmission_id"    => $this->transmission_id,
	        "version"            => $this->version,
	        "primary_image"      => $this->primary_image,
	        "secondary_image"    => $this->secondary_image,
	        "tertiary_image"     => $this->tertiary_image,
	        "production_year"    => $this->production_year,
            "release_year"       => $this->release_year,
	        "doors"              => $this->doors,
	        "motor"              => $this->motor,
	        "bodywork"           => $this->bodywork,
	        "automatic_pilot"    => $this->automatic_pilot,
	        "air_conditioner"    => $this->air_conditioner,
	        "automatic_glass"    => $this->automatic_glass,
	        "am_fm"              => $this->am_fm,
	        "auxiliary_input"    => $this->auxiliary_input,
	        "bluetooth"          => $this->bluetooth,
	        "cd_player"          => $this->cd_player,
	        "dvd_player"         => $this->dvd_player,
	        "mp3_reader"         => $this->mp3_reader,
	        "usb_port"           => $this->usb_port
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
        $selectCar = new Database('vehicle');

        $selectCar->join('model', 'vehicle.model_id = model.id');
        $selectCar->join('brand', 'model.brand_id = brand.id');
        $selectCar->join('fuel', 'vehicle.fuel_id  = fuel.id');
        $selectCar->join('transmission', 'vehicle.transmission_id = transmission.id');

        return $selectCar->select($where, $order, $limit, $fields ?? self::$fields);
    }

    /**
     * Método reponsável por retornar o veículo pelo id
     * @param integer $id
     * @return Car
     */
    public static function getCarById($id)
    {
        return self::getCars('vehicle.id = '. $id)->fetchObject(self::class);
    }
}
