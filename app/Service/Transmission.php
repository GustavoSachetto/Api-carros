<?php

namespace App\Service;

use Exception;
use App\Model\Entity\Transmission as EntityTransmission;
use App\Model\DatabaseManager\Pagination;

class Transmission extends Api
{
    /**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getTransmissionsItens($request, &$obPagination)
    {
        // ITENS
        $itens = [];

        // QUANTIDADE TOTAL DE REGISTROS
        $quatidadetotal = EntityTransmission::getTransmissions(null, null, null,'COUNT(*) as qtn')->fetchObject()->qtn;

        // PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quatidadetotal, $paginaAtual, 10);

        // RESULTADOS DA PÁGINA
        $results = EntityTransmission::getTransmissions(null,'id ASC', $obPagination->getLimit());

        // RENDERIZA O ITEM
        while($obTransmission = $results->fetchObject(EntityTransmission::class)) {
            $itens[] = [
                'id'               => $obTransmission->id,
                'nome_transmissao' => $obTransmission->nome_transmissao
            ];
        }

        // RETORNA  AS TRANSMISSÕES
        return $itens;
    }

    /**
     * Método responsável por retornar as transmissões cadastradas
     * @param Resquest $request
     * @return array
     */
    public static function getTransmissions($request)
    {
        return [
            'transmissoes' => self  ::getTransmissionsItens($request, $obPagination),
            'paginacao'    => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por retornar uma transmissão pelo seu id
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getTransmission($request, $id)
    {
        // VALIDA SE O ID É NUMERICO
        if (!is_numeric($id)) {
            throw new Exception("O id ".$id." não é válido.", 400);
        }    
        
        // BUSCA A TRANSMISSÃO 
        $obTransmission = EntityTransmission::getTransmissionById($id);

        // VERIFICA SE A TRANSMISSÃO EXISTE
        if (!$obTransmission instanceof EntityTransmission) {
            throw new Exception("A transmissão ".$id." não foi encontrada.", 404);
        }

        // RETORNA A TRANSMISSÃO
        return [
            'id'               => $obTransmission->id,
            'nome_transmissao' => $obTransmission->nome_transmissao
        ];
    }
}
