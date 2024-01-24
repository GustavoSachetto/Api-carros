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

    /**
     * Método responsável por cadastrar um novo combustivel
     * @param Request $request
     * @return array
     */
    public static function setNewFuel($request)
    {
        // POST VARS
        $postVars = $request->getPostVars();
        $nome = $postVars['nome_combustivel'] ?? null;

        // VALIDA O NOME
        if (!isset($nome)) {
            throw new Exception("O campo 'nome_combustivel' é obrigatório.", 400);
        } else if (empty($nome)) {
            throw new Exception("O campo 'nome_combustivel' não pode estar vazio.", 400);
        }

        // BUSCA COMBUSTÍVEL
        $obFuel = EntityFuel::getFuelByName($nome);

        // VALIDA SE O COMBUSTÍVEL JÁ EXISTE
        if ($obFuel instanceof EntityFuel) {
            throw new Exception("Combustível ".$nome." já existente.", 400);
        }

        // CADASTRA UMA NOVA INSTÂNCIA NO BANCO
        $obFuel = new EntityFuel;
        $obFuel->nome_combustivel = $nome;
        $obFuel->cadastrar();

        // RETORNA OS DETALHES DO COMBUSTÍVEL CADASTRADO
        return [
            'id' => $obFuel->id,
            'nome_combustivel' => $obFuel->nome_combustivel,
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
        $obFuel->nome_combustivel = $postVars['nome_combustivel'] ?? $obFuel->nome_combustivel;

        // ATUALIZANDO INSTÂNCIA
        $obFuel->atualizar();

        // RETORNA OS DETALHES DO COMBUSTÍVEL ATUALIZADO
        return [
            'id'      => $obFuel->id,
            'success' => true
        ];
    }
}
