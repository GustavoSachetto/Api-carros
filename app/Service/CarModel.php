<?php

namespace App\Service;

use Exception;
use App\Model\Entity\CarModel as EntityCarModel;

class CarModel extends Api
{
    /**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @return string
     */
    private static function getCarModelsItens($request, $where = null)
    {
        $itens = [];
        $results = EntityCarModel::getCarModels($where,'id ASC');

        while($obCarModel = $results->fetchObject(EntityCarModel::class)) {
            $itens[] = [
                'id'          => $obCarModel->id,
                'id_marca'    => $obCarModel->brand_id,
                'nome_modelo' => $obCarModel->name
            ];
        }

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
            'id_marca'    => $obCarModel->brand_id,
            'nome_modelo' => $obCarModel->name
        ];
    }

    /**
     * Método responsável por retornar modelos de veículos pelo id da marca
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getCarModelsByBrand($request, $id)
    {
        return self::getCarModelsItens($request, 'brand_id = '.$id);
    }

    /**
     * Método responsável por cadastrar um novo modelo de veículo
     * @param Request $request
     * @return array
     */
    public static function setNewCarModel($request)
    {
        // POST VARS
        $postVars = $request->getPostVars();
        $brand_id = $postVars['id_marca'] ?? null;
        $name     = $postVars['nome_modelo'] ?? null;

        // VALIDA O NOME DO MODELO E O ID DA MARCA
        if (!isset($name) || !isset($brand_id)) {
            throw new Exception("Os campos 'nome_modelo' e 'id_marca' são obrigatórios.", 400);
        } else if (empty($name) || !isset($brand_id)) {
            throw new Exception("Os campos 'nome_modelo' e 'id_marca' não podem estar vazios.", 400);
        }

        // BUSCA MODELO DE VEÍCULO
        $obCarModel = EntityCarModel::getCarModelByNameAndId($name, $brand_id);

        // VALIDA SE O MODELO DE VEÍCULO JÁ EXISTE
        if ($obCarModel instanceof EntityCarModel) {
            throw new Exception("Modelo ".$name." já existente na marca de id ".$brand_id.".", 400);
        }

        // CADASTRA UMA NOVA INSTÂNCIA NO BANCO
        $obCarModel = new EntityCarModel;
        $obCarModel->brand_id = $brand_id;
        $obCarModel->name = $name;
        $obCarModel->create();

        // RETORNA OS DETALHES DO MODELO CADASTRADO
        return [
            'id'          => $obCarModel->id,
            'nome_modelo' => $obCarModel->name,
            'success'     => true
        ];
    }

    /**
     * Método responsável por atualizar um modelo de veículo
     * @param Request $request
     * @return array
     */
    public static function setEditCarModel($request, $id)
    {
        // VALIDA SE O ID É NUMERICO
        if (!is_numeric($id)) {
            throw new Exception("O id ".$id." não é válido.", 400);
        }

        // POST VARS
        $postVars = $request->getPostVars();
        $brand_id = $postVars['id_marca'] ?? null;
        $name     = $postVars['nome_modelo'] ?? null;

        // VALIDANDO CAMPO OBRIGATÓRIO
        if (!isset($name) || !isset($brand_id)) {
            throw new Exception("Os campos 'nome_modelo' e 'id_marca' são obrigatórios.", 400);
        } else if (empty($name) || !isset($brand_id)) {
            throw new Exception("Os campos 'nome_modelo' e 'id_marca' não podem estar vazios.", 400);
        }

        // BUSCA MODELO DE VEÍCULO
        $obCarModel = EntityCarModel::getCarModelByNameAndId($name, $brand_id);

        // VALIDA SE O MODELO DE VEÍCULO JÁ EXISTE
        if ($obCarModel instanceof EntityCarModel) {
            throw new Exception("Modelo ".$name." já existente na marca de id ".$brand_id.".", 400);
        }

        // BUSCA MODELO DE VEÍCULO
        $obCarModel = EntityCarModel::getCarModelById($id);

        // VERIFICA SE O MODELO DE VEÍCULO EXISTE
        if (!$obCarModel instanceof EntityCarModel) {
            throw new Exception("O modelo ".$id." não foi encontrado.", 404);
        }

        // VALIDANDO ALTERAÇÕES
        $obCarModel->brand_id = $brand_id ?? $obCarModel->brand_id;
        $obCarModel->name     = $name ?? $obCarModel->name;

        // ATUALIZANDO INSTÂNCIA
        $obCarModel->update();

        // RETORNA OS DETALHES DO MODELO DE VEÍCULO ATUALIZADO
        return [
            'id'      => $obCarModel->id,
            'success' => true
        ];
    }
}
