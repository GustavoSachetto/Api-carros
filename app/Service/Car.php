<?php

namespace App\Service;

use Exception;
use App\Model\Entity\Car as EntityCar;
use App\Model\DatabaseManager\Pagination;

class Car extends Api
{
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
            $itens[] = [
                'id'          => $obCar->id,
                'valor'       => $obCar->valor,
                'cod_marca'   => $obCar->id_marca,
                'marca'       => $obCar->nome_marca,
                'cod_modelo'  => $obCar->id_modelo,
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
            'id'          => $obCar->id,
            'valor'       => $obCar->valor,
            'cod_marca'   => $obCar->id_marca,
            'marca'       => $obCar->nome_marca,
            'cod_modelo'  => $obCar->id_modelo,
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
}
