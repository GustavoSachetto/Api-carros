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
        // ITENS
        $itens = [];

        // RESULTADOS DA PÁGINA
        $results = EntityCarModel::getCarModels($where,'id ASC');

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

    /**
     * Método responsável por retornar modelos de veículos pelo id da marca
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getCarModelsByBrand($request, $id)
    {
        return self::getCarModelsItens($request, 'id_marca = '.$id);
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
        $id_marca = $postVars['id_marca'] ?? null;
        $nome     = $postVars['nome_modelo'] ?? null;

        // VALIDA O NOME DO MODELO E O ID DA MARCA
        if (!isset($nome) || !isset($id_marca)) {
            throw new Exception("Os campos 'nome_modelo' e 'id_marca' são obrigatórios.", 400);
        } else if (empty($nome) || !isset($id_marca)) {
            throw new Exception("Os campos 'nome_modelo' e 'id_marca' não podem estar vazios.", 400);
        }

        // BUSCA MODELO DE VEÍCULO
        $obCarModel = EntityCarModel::getCarModelByNameAndId($nome, $id_marca);

        // VALIDA SE O MODELO DE VEÍCULO JÁ EXISTE
        if ($obCarModel instanceof EntityCarModel) {
            throw new Exception("Modelo ".$nome." já existente na marca de id ".$id_marca.".", 400);
        }

        // CADASTRA UMA NOVA INSTÂNCIA NO BANCO
        $obCarModel = new EntityCarModel;
        $obCarModel->id_marca = $id_marca;
        $obCarModel->nome_modelo = $nome;
        $obCarModel->cadastrar();

        // RETORNA OS DETALHES DO MODELO CADASTRADO
        return [
            'id'          => $obCarModel->id,
            'nome_modelo' => $obCarModel->nome_modelo,
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
        $id_marca = $postVars['id_marca'] ?? null;
        $nome     = $postVars['nome_modelo'] ?? null;

        // VALIDANDO CAMPO OBRIGATÓRIO
        if (!isset($nome) || !isset($id_marca)) {
            throw new Exception("Os campos 'nome_modelo' e 'id_marca' são obrigatórios.", 400);
        } else if (empty($nome) || !isset($id_marca)) {
            throw new Exception("Os campos 'nome_modelo' e 'id_marca' não podem estar vazios.", 400);
        }

        // BUSCA MODELO DE VEÍCULO
        $obCarModel = EntityCarModel::getCarModelByNameAndId($nome, $id_marca);

        // VALIDA SE O MODELO DE VEÍCULO JÁ EXISTE
        if ($obCarModel instanceof EntityCarModel) {
            throw new Exception("Modelo ".$nome." já existente na marca de id ".$id_marca.".", 400);
        }

        // BUSCA MODELO DE VEÍCULO
        $obCarModel = EntityCarModel::getCarModelById($id);

        // VERIFICA SE O MODELO DE VEÍCULO EXISTE
        if (!$obCarModel instanceof EntityCarModel) {
            throw new Exception("O modelo ".$id." não foi encontrado.", 404);
        }

        // VALIDANDO ALTERAÇÕES
        $obCarModel->id_marca    = $id_marca ?? $obCarModel->id_marca;
        $obCarModel->nome_modelo = $nome ?? $obCarModel->nome_modelo;

        // ATUALIZANDO INSTÂNCIA
        $obCarModel->atualizar();

        // RETORNA OS DETALHES DO MODELO DE VEÍCULO ATUALIZADO
        return [
            'id'      => $obCarModel->id,
            'success' => true
        ];
    }
}
