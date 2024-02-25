<?php

namespace App\Service;

use Exception;
use App\Model\Entity\Car as EntityCar;
use App\Model\DatabaseManager\Pagination;

class Car extends Api
{
    /**
     * Método reponsável por retornar o array de veículo
     * @var array
     */
    private static function setCarArray(&$obCar) {
        return [
            'id'          => $obCar->id,
            'valor'       => $obCar->price,
            'id_marca'   => $obCar->brand_id,
            'marca'       => $obCar->brand_name,
            'id_modelo'  => $obCar->model_id,
            'modelo'      => $obCar->model_name,
            'versao'      => $obCar->version,
            'imagens'     => [
                $obCar->primary_image,
                $obCar->secondary_image,
                $obCar->tertiary_image
            ],
            'ano'            => [
                'producao'   => $obCar->production_year,
                'lancamento' => $obCar->release_year
            ],
            'combustivel' => $obCar->fuel_name,
            'portas'      => $obCar->doors,
            'transmissao' => $obCar->transmission_name,
            'motor'       => $obCar->motor,
            'carroceria'  => $obCar->bodywork,
            'conforto'    => [
                'piloto_automatico' => (bool)$obCar->automatic_pilot,
                'climatizador'      => (bool)$obCar->air_conditioner,
                'vidro_automatico'  => (bool)$obCar->automatic_glass
            ],
            'entretenimento' => [
                'am_fm'            => (bool)$obCar->am_fm,
                'entrada_auxiliar' => (bool)$obCar->auxiliary_input,
                'bluetooth'        => (bool)$obCar->bluetooth,
                'cd_player'        => (bool)$obCar->cd_player,
                'dvd_player'       => (bool)$obCar->dvd_player,
                'leitor_mp3'       => (bool)$obCar->mp3_reader,
                'entrada_usb'      => (bool)$obCar->usb_port
            ]
        ];
    }

    /**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getCarItens($request, &$obPagination)
    {
        $itens = [];
        $quatidadetotal = EntityCar::getCars(null, null, null,'COUNT(*) as qtn')->fetchObject()->qtn;

        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quatidadetotal, $paginaAtual, 5);

        $results = EntityCar::getCars(null,'vehicle.id DESC', $obPagination->getLimit());

        while($obCar = $results->fetchObject(EntityCar::class)) {
            $itens[] = self::setCarArray($obCar);
        }

        return $itens;
    }

    /**
     * Método responsável por retornar os veículos cadastrados
     * @param Resquest $request
     * @return array
     */
    public static function getCars($request)
    {
        return [
            'veiculos'  => self  ::getCarItens($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por retornar um veículo pelo seu id
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getCar($request, $id)
    {
        // VALIDA SE O ID É NUMERICO
        if (!is_numeric($id)) {
            throw new Exception("O id ".$id." não é válido.", 400);
        }    
        
        // BUSCA CARRO 
        $obCar = EntityCar::getCarById($id);

        // VERIFICA SE O CARRO EXISTE
        if (!$obCar instanceof EntityCar) {
            throw new Exception("O veiculo ".$id." não foi encontrado.", 404);
        }

        // RETORNA O CARRO
        return self::setCarArray($obCar);
    }

    /**
     * Método responsável por cadastrar um novo veículo
     * @param Request $request
     * @return array
     */
    public static function setNewCar($request)
    {
        // POST VARS
        $postVars = $request->getPostVars();

        // VALIDA SE Á CAMPOS OBRIGATÓRIOS NÃO EXISTENTES
        if (
            !isset($postVars['valor']) || 
            !isset($postVars['id_modelo']) || 
            !isset($postVars['id_combustivel']) || 
            !isset($postVars['id_transmissao']) || 
            !isset($postVars['versao']) || 
            !isset($postVars['imagem_um']) || 
            !isset($postVars['ano_producao']) || 
            !isset($postVars['ano_lancamento']) || 
            !isset($postVars['portas']) || 
            !isset($postVars['carroceria'])) 
            {

            // RETORNA ERRO
            throw new Exception("Um dos campos obrigatórios do veículo não está preenchido.", 400);
        }
        
        // INSTÂNCIANDO NOVO OBJETO
        $obCar = new EntityCar;

        // ADICIONANDO VALORES
        $obCar->price           = $postVars['valor'];
        $obCar->model_id        = $postVars['id_modelo'];
        $obCar->fuel_id         = $postVars['id_combustivel'];
        $obCar->transmission_id = $postVars['id_transmissao'];
        $obCar->version         = $postVars['versao'];
        $obCar->primary_image   = $postVars['imagem_um'];
        $obCar->secondary_image = $postVars['imagem_dois'] ?? null;
        $obCar->tertiary_image  = $postVars['imagem_tres'] ?? null;
        $obCar->production_year = $postVars['ano_producao'];
        $obCar->release_year    = $postVars['ano_lancamento'];
        $obCar->doors           = $postVars['portas'];
        $obCar->motor           = $postVars['motor'];
        $obCar->bodywork        = $postVars['carroceria'];     
        $obCar->automatic_pilot = $postVars['piloto_automatico'] ?? false;
        $obCar->air_conditioner = $postVars['climatizador'] ?? false;
        $obCar->automatic_glass = $postVars['vidro_automatico'] ?? false;
        $obCar->am_fm           = $postVars['am_fm'] ?? false;        
        $obCar->auxiliary_input = $postVars['entrada_auxiliar'] ?? false;
        $obCar->bluetooth       = $postVars['bluetooth'] ?? false;         
        $obCar->cd_player       = $postVars['cd_player'] ?? false;
        $obCar->dvd_player      = $postVars['dvd_player'] ?? false;      
        $obCar->mp3_reader      = $postVars['leitor_mp3'] ?? false;            
        $obCar->usb_port        = $postVars['entrada_usb'] ?? false;            
        
        // CADASTRANDO VEÍCULO
        $obCar->create();

        // RETORNA O ID DO VEÍCULO CADASTRADO
        return [
            'id' => $obCar->id,
            'success' => true
        ]; 
    }
}
