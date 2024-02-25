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
        $itens = [];
        $results = EntityFuel::getFuels(null,'id ASC');

        while($obFuel = $results->fetchObject(EntityFuel::class)) {
            $itens[] = [
                'id'               => $obFuel->id,
                'nome_combustivel' => $obFuel->name
            ];
        }

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
            'nome_combustivel' => $obFuel->name
        ];
    }

    /**
     * Método responsável por cadastrar um novo combustivel
     * @param Request $request
     * @return array
     */
    public static function setNewFuel($request)
    {
        // POST VARS
        $postVars = $request->getPostVars();
        $name = $postVars['nome_combustivel'] ?? null;

        // VALIDA O NOME
        if (!isset($name)) {
            throw new Exception("O campo 'nome_combustivel' é obrigatório.", 400);
        } else if (empty($name)) {
            throw new Exception("O campo 'nome_combustivel' não pode estar vazio.", 400);
        }

        // BUSCA COMBUSTÍVEL
        $obFuel = EntityFuel::getFuelByName($name);

        // VALIDA SE O COMBUSTÍVEL JÁ EXISTE
        if ($obFuel instanceof EntityFuel) {
            throw new Exception("Combustível ".$name." já existente.", 400);
        }

        // CADASTRA UMA NOVA INSTÂNCIA NO BANCO
        $obFuel = new EntityFuel;
        $obFuel->name = $name;
        $obFuel->create();

        // RETORNA OS DETALHES DO COMBUSTÍVEL CADASTRADO
        return [
            'id' => $obFuel->id,
            'nome_combustivel' => $obFuel->name,
            'success' => true
        ];
    }

    /**
     * Método responsável por atualizar um combustível
     * @param Request $request
     * @return array
     */
    public static function setEditFuel($request, $id)
    {
        // VALIDA SE O ID É NUMERICO
        if (!is_numeric($id)) {
            throw new Exception("O id ".$id." não é válido.", 400);
        }

        // POST VARS
        $postVars = $request->getPostVars();

        // VALIDANDO CAMPO OBRIGATÓRIO
        if (!isset($postVars['nome_combustivel'])) {
            throw new Exception("O campo 'nome_combustivel' é obrigatório.", 400);
        }

        // BUSCA COMBUSTÍVEL PELO NOME
        $obFuel = EntityFuel::getFuelByName($postVars['nome_combustivel']);

        // VALIDA COMBUSTÍVEL DUPLICADA
        if ($obFuel instanceof EntityFuel) {
            throw new Exception("Combustível ".$postVars['nome_combustivel']." já existente. Combustível duplicado.", 400);
        }

        // BUSCA COMBUSTÍVEL
        $obFuel = EntityFuel::getFuelById($id);

        // VERIFICA SE O COMBUSTÍVEL EXISTE
        if (!$obFuel instanceof EntityFuel) {
            throw new Exception("O combustível ".$id." não foi encontrado.", 404);
        }

        // VALIDANDO ALTERAÇÕES
        $obFuel->name = $postVars['nome_combustivel'] ?? $obFuel->name;

        // ATUALIZANDO INSTÂNCIA
        $obFuel->update();

        // RETORNA OS DETALHES DO COMBUSTÍVEL ATUALIZADO
        return [
            'id'      => $obFuel->id,
            'success' => true
        ];
    }
}
