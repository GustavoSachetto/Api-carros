<?php

namespace App\Service;

use Exception;
use App\Model\Entity\Fuel as EntityFuel;

class Fuel extends Api
{
    /**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @return string
     */
    private static function getFuelsItens($request)
    {
        // ITENS
        $itens = [];

        // RESULTADOS DA PÁGINA
        $results = EntityFuel::getFuels(null,'id ASC');

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
        return self::getFuelsItens($request);
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
        
        // BUSCA COMBUSTÍVEL 
        $obFuel = EntityFuel::getFuelById($id);

        // VERIFICA SE O COMBUSTÍVEL EXISTE
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
