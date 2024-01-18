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
            'valor'       => $obCar->valor,
            'id_marca'   => $obCar->id_marca,
            'marca'       => $obCar->nome_marca,
            'id_modelo'  => $obCar->id_modelo,
            'modelo'      => $obCar->nome_modelo,
            'versao'      => $obCar->versao,
            'imagens'     => [
                $obCar->imagem_um,
                $obCar->imagem_dois,
                $obCar->imagem_tres
            ],
            'ano'            => [
                'producao'   => $obCar->ano_producao,
                'lancamento' => $obCar->ano_lancamento
            ],
            'combustivel' => $obCar->nome_combustivel,
            'portas'      => $obCar->portas,
            'transmissao' => $obCar->nome_transmissao,
            'motor'       => $obCar->motor,
            'carroceria'  => $obCar->carroceria,
            'conforto'    => [
                'piloto_automatico' => (bool)$obCar->piloto_automatico,
                'climatizador'      => (bool)$obCar->climatizador,
                'vidro_automatico'  => (bool)$obCar->vidro_automatico
            ],
            'entretenimento' => [
                'am_fm'            => (bool)$obCar->am_fm,
                'entrada_auxiliar' => (bool)$obCar->entrada_auxiliar,
                'bluetooth'        => (bool)$obCar->bluetooth,
                'cd_player'        => (bool)$obCar->cd_player,
                'dvd_player'       => (bool)$obCar->dvd_player,
                'leitor_mp3'       => (bool)$obCar->leitor_mp3,
                'entrada_usb'      => (bool)$obCar->entrada_usb
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
        // ITENS
        $itens = [];

        // QUANTIDADE TOTAL DE REGISTROS
        $quatidadetotal = EntityCar::getCars(null, null, null,'COUNT(*) as qtn')->fetchObject()->qtn;

        // PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quatidadetotal, $paginaAtual, 5);

        // RESULTADOS DA PÁGINA
        $results = EntityCar::getCars(null,'veiculo.id DESC', $obPagination->getLimit());

        // RENDERIZA O ITEM
        while($obCar = $results->fetchObject(EntityCar::class)) {
            $itens[] = self::setCarArray($obCar);
        }

        // RETORNA OS CARROS
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
        return [
            self::setCarArray($obCar)
        ];
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
        if (!isset($postVars['valor']) || !isset($postVars['id_modelo']) || !isset($postVars['id_combustivel']) || !isset($postVars['id_transmissao']) || !isset($postVars['versao']) || !isset($postVars['imagem_um']) || !isset($postVars['ano_producao']) || !isset($postVars['ano_lancamento']) || !isset($postVars['portas']) || !isset($postVars['carroceria'])) {
            // RETORNA ERRO
            throw new Exception("Um dos campos obrigatórios do veículo não está preenchido.", 400);
        }
        
        // INSTÂNCIANDO NOVO OBJETO
        $obCar = new EntityCar;

        // ADICIONANDO VALORES
        foreach ($postVars as $key => $value) {
            $obCar->$key = $value;
        }

        // CADASTRANDO VEÍCULO
        $obCar->cadastrar();

        // RETORNA O ID DO VEÍCULO CADASTRADO
        return [
            'id' => $obCar->id,
            'success' => true
        ]; 
    }
}
