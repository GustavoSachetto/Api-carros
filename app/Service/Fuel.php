<?php

namespace App\Service;

use Exception;
use App\Model\Entity\Fuel as EntityFuel;
use App\Model\DatabaseManager\Pagination;

class Fuel extends Api
{
    /**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getFuelsItens($request, &$obPagination)
    {
        // ITENS
        $itens = [];

        // QUANTIDADE TOTAL DE REGISTROS
        $quatidadetotal = EntityFuel::getFuels(null, null, null,'COUNT(*) as qtn')->fetchObject()->qtn;

        // PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quatidadetotal, $paginaAtual, 10);

        // RESULTADOS DA PÁGINA
        $results = EntityFuel::getFuels(null,'id ASC', $obPagination->getLimit());

        // RENDERIZA O ITEM
        while($obFuel = $results->fetchObject(EntityFuel::class)) {
            $itens[] = [
                'id'               => $obFuel->id,
                'nome_combustivel' => $obFuel->nome_combustivel
            ];
        }

        // RETORNA OS COMBUSTÍVEIS
        return $itens;
    }

    /**
     * Método responsável por retornar os combustíveis cadastrados
     * @param Resquest $request
     * @return array
     */
    public static function getFuels($request)
    {
        return [
            'combustiveis'  => self  ::getFuelsItens($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por retornar um combustível pelo seu id
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getFuel($request, $id)
    {
        // VALIDA SE O ID É NUMERICO
        if (!is_numeric($id)) {
            throw new Exception("O id ".$id." não é válido.", 400);
        }    
        
        // BUSCA CARRO 
        $obFuel = EntityFuel::getFuelById($id);

        // VERIFICA SE O CARRO EXISTE
        if (!$obFuel instanceof EntityFuel) {
            throw new Exception("O combustível ".$id." não foi encontrado.", 404);
        }

        // RETORNA O COMBUSTÍVEL
        return [
            'id'               => $obFuel->id,
            'nome_combustivel' => $obFuel->nome_combustivel
        ];
    }
}
