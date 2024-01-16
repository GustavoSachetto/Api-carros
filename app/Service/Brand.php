<?php

namespace App\Service;

use Exception;
use App\Model\Entity\Brand as EntityBrand;
use App\Model\DatabaseManager\Pagination;

class Brand extends Api
{
    /**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getBrandsItens($request, &$obPagination)
    {
        // ITENS
        $itens = [];

        // QUANTIDADE TOTAL DE REGISTROS
        $quatidadetotal = EntityBrand::getBrands(null, null, null,'COUNT(*) as qtn')->fetchObject()->qtn;

        // PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quatidadetotal, $paginaAtual, 10);

        // RESULTADOS DA PÁGINA
        $results = EntityBrand::getBrands(null,'id ASC', $obPagination->getLimit());

        // RENDERIZA O ITEM
        while($obFuel = $results->fetchObject(EntityBrand::class)) {
            $itens[] = [
                'id'         => $obFuel->id,
                'nome_marca' => $obFuel->nome_marca
            ];
        }

        // RETORNA AS MARCAS
        return $itens;
    }

    /**
     * Método responsável por retornar as marcas cadastradas
     * @param Resquest $request
     * @return array
     */
    public static function getBrands($request)
    {
        return [
            'marcas'    => self  ::getBrandsItens($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por retornar uma marca pelo seu id
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getBrand($request, $id)
    {
        // VALIDA SE O ID É NUMERICO
        if (!is_numeric($id)) {
            throw new Exception("O id ".$id." não é válido.", 400);
        }    
        
        // BUSCA MARCA 
        $obFuel = EntityBrand::getBrandById($id);

        // VERIFICA SE A MARCA EXISTE
        if (!$obFuel instanceof EntityBrand) {
            throw new Exception("A marca ".$id." não foi encontrado.", 404);
        }

        // RETORNA A MARCA
        return [
            'id'         => $obFuel->id,
            'nome_marca' => $obFuel->nome_marca
        ];
    }
}
