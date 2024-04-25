<?php

namespace App\Model\Entity;

use PDOStatement;
use App\Model\DatabaseManager\Database;

class Car
{
    public int $id;

    public float $price;
    public string $version;

    public int $brand_id;
    public int $model_id;
    public int $fuel_id; 
    public int $transmission_id;

    public string $brand_name;
    public string $model_name;
    public string $fuel_name;
    public string $transmission_name;

    public string $primary_image;
    public string|null $secondary_image = null;
    public string|null $tertiary_image = null;

    public int $production_year;
    public int $release_year;

    public int $doors;
    public float $motor;
    public string $bodywork;

    public bool $automatic_pilot = false;
    public bool $air_conditioner = false;
    public bool $automatic_glass = false;
    public bool $am_fm = false;
    public bool $auxiliary_input = false;
    public bool $bluetooth = false;
    public bool $cd_player = false;
    public bool $dvd_player = false;
    public bool $mp3_reader = false;
    public bool $usb_port = false;

    public bool $deleted = false;

    /** 
     * Campos a serem unidos na select do veículo
    */
    private static $fields = "vehicle.*, model.name as model_name, model.brand_id,  brand.name as brand_name, fuel.name as fuel_name, transmission.name as transmission_name";

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     */
    public function create(): bool
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
     * Método responsável por atualizar os dados do banco com a instância atual
     */
    public function update(): bool
    {
        return (new Database('vehicle'))->update('id = '.$this->id, [
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
	        "usb_port"           => $this->usb_port,
            'deleted'            => $this->deleted
        ]);
    }

    /**
     * Método responsável por excluir um dado no banco com a instância atual
     */
    public function delete(): bool
    {
        return (new Database('vehicle'))->securityDelete('id = '.$this->id);
    }

    /**
     * Método que retorna os veículos cadastrados no banco
     */
    public static function getCars(
        string $where = null, 
        string $order = null, 
        string $limit = null, 
        string $fields = null
        ): PDOStatement
    {
        $DBVehicle = new Database('vehicle');

        $DBVehicle->join('model', 'vehicle.model_id = model.id');
        $DBVehicle->join('brand', 'model.brand_id = brand.id');
        $DBVehicle->join('fuel', 'vehicle.fuel_id  = fuel.id');
        $DBVehicle->join('transmission', 'vehicle.transmission_id = transmission.id');

        return $DBVehicle->select($where, $order, $limit, $fields ?? self::$fields);
    }

    /**
     * Método reponsável por retornar um veículo pelo seu ID
     */
    public static function getCarById(string $id): Car|string
    {
        return self::getCars('vehicle.id = '. $id)->fetchObject(self::class);
    }
}
