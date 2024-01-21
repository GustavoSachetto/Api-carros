<?php

namespace App\Service;

use Exception;
use App\Model\Entity\CarModel as EntityCarModel;

class CarModel
{
    /**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @return string
     */
    private static function getCarModelsItens($request)
    {
        // ITENS
        $itens = [];

        // RESULTADOS DA PÁGINA
        $results = EntityCarModel::getCarModels(null,'id ASC');

        // RENDERIZA O ITEM
        while($obCarModel = $results->fetchObject(EntityCarModel::class)) {
            $itens[] = [
                'id'          => $obCarModel->id,
                'id_marca'    => $obCarModel->id_marca,
                'nome_modelo' => $obCarModel->nome_modelo
            ];
        }

        // RETORNA OS MODELOS DOS VEÍCULOS
        return $itens;
    }

    /**
     * Método responsável por retornar os modelos dos veículos cadastrados
     * @param Resquest $request
     * @return array
     */
    public static function getCarModels($request)
    {
        return self::getCarModelsItens($request);
    }

    /**
     * Método responsável por retornar um modelo de veículo pelo seu id
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getCarModel($request, $id)
    {
        // VALIDA SE O ID É NUMERICO
        if (!is_numeric($id)) {
            throw new Exception("O id ".$id." não é válido.", 400);
        }    
        
        // BUSCA MODELO DE VEÍCULO
        $obCarModel = EntityCarModel::getCarModelById($id);

        // VERIFICA SE O MODELO DE VEÍCULO EXISTE
        if (!$obCarModel instanceof EntityCarModel) {
            throw new Exception("O modelo de carro ".$id." não foi encontrado.", 404);
        }

        // RETORNA O MODELO DE VEÍCULO
        return [
            'id'          => $obCarModel->id,
            'id_marca'    => $obCarModel->id_marca,
            'nome_modelo' => $obCarModel->nome_modelo
        ];
    }
}
