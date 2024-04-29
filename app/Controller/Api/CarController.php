<?php

namespace App\Controller\Api;

use App\Http\Request;
use App\Controller\Api;
use App\Utils\Examiner;
use App\Exception\Car as ExceptionCar;
use App\Model\Entity\Car as EntityCar;
use App\Model\DatabaseManager\Pagination;

class CarController extends Api
{
    /** 
     * Método responsável por definir as possíveis mensagens das exceções
    */
    private static function init(): void
    {
        Examiner::$exception = ExceptionCar::class;
    }

    /** 
     * Método reponsável por definir um limite de veículos por pagina 
    */
    private static function getPaginationLimit(array $vars, int $limit): string
    {
        $total = EntityCar::getCars(null, null, null, 'COUNT(*) as qtn')->fetchObject()->qtn;
        $currentPage = $vars['page'] ?? 1;

        return (new Pagination($total, $currentPage, $limit))->getLimit();
    }

    /** 
     * Método responsável por setar o array de retorno do veículo
    */
    private static function formatterArray(EntityCar|string $obCar): array 
    {
        return [
            'id'                  => $obCar->id,
            'price'               => (int)$obCar->price,
            'brand_id'            => $obCar->brand_id,
            'brand_name'          => $obCar->brand_name,
            'model_id'            => $obCar->model_id,
            'model_name'          => $obCar->model_name,
            'version'             => $obCar->version,
            'images'              => [
                $obCar->primary_image,
                $obCar->secondary_image,
                $obCar->tertiary_image
            ],
            'year'                => [
                'production'      => $obCar->production_year,
                'release'         => $obCar->release_year
            ],
            'fuel_name'           => $obCar->fuel_name,
            'doors'               => $obCar->doors,
            'transmission_name'   => $obCar->transmission_name,
            'motor'               => $obCar->motor,
            'bodywork'            => $obCar->bodywork,
            'comfort'             => [
                'automatic_pilot' => (bool)$obCar->automatic_pilot,
                'air_conditioner' => (bool)$obCar->air_conditioner,
                'automatic_glass' => (bool)$obCar->automatic_glass
            ],
            'entertainment'       => [
                'am_fm'           => (bool)$obCar->am_fm,
                'auxiliary_input' => (bool)$obCar->auxiliary_input,
                'bluetooth'       => (bool)$obCar->bluetooth,
                'cd_player'       => (bool)$obCar->cd_player,
                'dvd_player'      => (bool)$obCar->dvd_player,
                'mp3_reader'      => (bool)$obCar->mp3_reader,
                'usb_port'        => (bool)$obCar->usb_port
            ]
        ];
    }

    /** 
     * Método responsável por setar os campos do veículo
    */
    private static function setCarFields(EntityCar $obCar, array $vars): void
    {
        $obCar->price           = $vars['price']            ?? $obCar->price;
        $obCar->model_id        = $vars['model_id']         ?? $obCar->model_id;
        $obCar->fuel_id         = $vars['fuel_id']          ?? $obCar->fuel_id;
        $obCar->transmission_id = $vars['transmission_id']  ?? $obCar->transmission_id;
        $obCar->version         = $vars['version']          ?? $obCar->version;
        $obCar->primary_image   = $vars['primary_image']    ?? $obCar->primary_image;
        $obCar->secondary_image = $vars['secondary_image']  ?? $obCar->secondary_image;
        $obCar->tertiary_image  = $vars['tertiary_image']   ?? $obCar->tertiary_image;
        $obCar->production_year = $vars['production_year']  ?? $obCar->production_year;
        $obCar->release_year    = $vars['release_year']     ?? $obCar->release_year;
        $obCar->doors           = $vars['doors']            ?? $obCar->doors;
        $obCar->motor           = $vars['motor']            ?? $obCar->motor;
        $obCar->bodywork        = $vars['bodywork']         ?? $obCar->bodywork;     
        $obCar->automatic_pilot = $vars['automatic_pilot']  ?? $obCar->automatic_pilot;
        $obCar->air_conditioner = $vars['air_conditioner']  ?? $obCar->air_conditioner;
        $obCar->automatic_glass = $vars['automatic_glass']  ?? $obCar->automatic_glass;
        $obCar->am_fm           = $vars['am_fm']            ?? $obCar->am_fm;        
        $obCar->auxiliary_input = $vars['auxiliary_input']  ?? $obCar->auxiliary_input;
        $obCar->bluetooth       = $vars['bluetooth']        ?? $obCar->bluetooth;         
        $obCar->cd_player       = $vars['cd_player']        ?? $obCar->cd_player;
        $obCar->dvd_player      = $vars['dvd_player']       ?? $obCar->dvd_player;      
        $obCar->mp3_reader      = $vars['mp3_reader']       ?? $obCar->mp3_reader;            
        $obCar->usb_port        = $vars['usb_port']         ?? $obCar->usb_port;       
    }

    /** 
     * Método responsável por formartar os filtros da busca por veículos
    */
    private static function filter(array $vars): string
    {
        $filter = [];

        isset($vars['fuel'])         ? $filter[] = "vehicle.fuel_id = ".$vars['fuel']                 : null;
        isset($vars['brand'])        ? $filter[] = "model.brand_id = ".$vars['brand']                 : null;
        isset($vars['carmodel'])     ? $filter[] = "vehicle.model_id = ".$vars['carmodel']            : null;
        isset($vars['version'])      ? $filter[] = "vehicle.version LIKE %'".$vars['version']."'"     : null;
        isset($vars['transmission']) ? $filter[] = "vehicle.transmission_id = ".$vars['transmission'] : null;
        isset($vars['pricemax'])     ? $filter[] = "vehicle.price < ".$vars['pricemax']               : null;
        isset($vars['pricemin'])     ? $filter[] = "vehicle.price > ".$vars['pricemin']               : null;
        $filter[] = 'vehicle.deleted = false';

        return implode(" AND ", $filter);
    }

    /**
     * Método responsável por retornar os veículos existentes
     */
    public static function get(Request $request): array
    {   
        self::init();
        $vars = $request->getQueryParams();
        $results = EntityCar::getCars(self::filter($vars), 'vehicle.id DESC', self::getPaginationLimit($vars, 25));
        
        $itens = [];
        while($obCar = $results->fetchObject(EntityCar::class)) {
            $itens[] = self::formatterArray($obCar);
        }
        
        Examiner::checkArrayItens($itens);
        return $itens;
    }

    /**
     * Método responsável por retornar um veículo pelo seu id
     */
    public static function fetch(Request $request, int|string $id): array
    {   
        self::init();
        
        Examiner::checkId($id);
        $obCar = EntityCar::getCarById($id);
        Examiner::checkObjectExists($obCar, EntityCar::class);
        
        $arrayCar = self::formatterArray($obCar);
        $arrayCar['deleted'] = $obCar->deleted;
        
        return $arrayCar;
    }

    /**
     * Método responsável por setar um novo veículo
     */
    public static function set(Request $request): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkRequiredFields([
            'price'           => $vars['price']           ?? null,           
            'model_id'        => $vars['model_id']        ?? null,       
            'fuel_id'         => $vars['fuel_id']         ?? null,        
            'transmission_id' => $vars['transmission_id'] ?? null,
            'version'         => $vars['version']         ?? null,        
            'primary_image'   => $vars['primary_image']   ?? null,  
            'production_year' => $vars['production_year'] ?? null,
            'release_year'    => $vars['release_year']    ?? null,   
            'doors'           => $vars['doors']           ?? null,          
            'motor'           => $vars['motor']           ?? null,          
            'bodywork'        => $vars['bodywork']        ?? null       
        ]);

        $obCar = new EntityCar;
        self::setCarFields($obCar, $vars);
        $obCar->create();

        return [
            'id'      => $obCar->id,
            'success' => true
        ];
    }   
    
    /**
     * Método responsável por editar um veículo pelo seu id
     */
    public static function edit(Request $request, int|string $id): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkId($id);
        Examiner::checkRequiredFields([
            'price'           => $vars['price']           ?? null,           
            'model_id'        => $vars['model_id']        ?? null,       
            'fuel_id'         => $vars['fuel_id']         ?? null,        
            'transmission_id' => $vars['transmission_id'] ?? null,
            'version'         => $vars['version']         ?? null,        
            'primary_image'   => $vars['primary_image']   ?? null,  
            'production_year' => $vars['production_year'] ?? null,
            'release_year'    => $vars['release_year']    ?? null,   
            'doors'           => $vars['doors']           ?? null,          
            'motor'           => $vars['motor']           ?? null,          
            'bodywork'        => $vars['bodywork']        ?? null       
        ]);

        $obCar = EntityCar::getCarById($id);
        Examiner::checkObjectExists($obCar, EntityCar::class);

        self::setCarFields($obCar, $vars);
        $obCar->update();

        return [
            'id'      => $obCar->id,
            'success' => true
        ];
    }
    
    /**
     * Método responsável por deletar um veículo pelo seu id
     */
    public static function delete(Request $request, int|string $id): array
    {
        self::init();

        Examiner::checkId($id);
        $obCar = EntityCar::getCarById($id);
        Examiner::checkObjectExists($obCar, EntityCar::class);

        $obCar->delete();

        return [
            'success' => true
        ];
    }
}
