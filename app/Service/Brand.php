<?php

namespace App\Service;

use Exception;
use App\Model\Entity\Brand as EntityBrand;

class Brand extends Api
{
    /**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @return string
     */
    private static function getBrandsItens($request)
    {
        // ITENS
        $itens = [];

        // RESULTADOS DA PÁGINA
        $results = EntityBrand::getBrands(null,'id ASC');

        // RENDERIZA O ITEM
        while($obBrand = $results->fetchObject(EntityBrand::class)) {
            $itens[] = [
                'id'         => $obBrand->id,
                'nome_marca' => $obBrand->nome_marca
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
        return self::getBrandsItens($request);
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
        $obBrand = EntityBrand::getBrandById($id);

        // VERIFICA SE A MARCA EXISTE
        if (!$obBrand instanceof EntityBrand) {
            throw new Exception("A marca ".$id." não foi encontrado.", 404);
        }

        // RETORNA A MARCA
        return [
            'id'         => $obBrand->id,
            'nome_marca' => $obBrand->nome_marca
        ];
    }
}