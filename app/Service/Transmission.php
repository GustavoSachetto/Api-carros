<?php

namespace App\Service;

use Exception;
use App\Model\Entity\Transmission as EntityTransmission;

class Transmission extends Api
{
    /**
     * Método responsável por obter a renderização dos itens da api
     * @param Request $request
     * @return string
     */
    private static function getTransmissionsItens($request)
    {
        $itens = [];
        $results = EntityTransmission::getTransmissions(null,'id ASC');

        while($obTransmission = $results->fetchObject(EntityTransmission::class)) {
            $itens[] = [
                'id'               => $obTransmission->id,
                'nome_transmissao' => $obTransmission->name
            ];
        }

        return $itens;
    }

    /**
     * Método responsável por retornar as transmissões cadastradas
     * @param Resquest $request
     * @return array
     */
    public static function getTransmissions($request)
    {
        return self::getTransmissionsItens($request);
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
            'nome_transmissao' => $obTransmission->name
        ];
    }

    /**
     * Método responsável por cadastrar uma nova transmissão
     * @param Request $request
     * @return array
     */
    public static function setNewTransmission($request)
    {
        // POST VARS
        $postVars = $request->getPostVars();
        $name = $postVars['nome_transmissao'] ?? null;

        // VALIDA O NOME
        if (!isset($name)) {
            throw new Exception("O campo 'nome_transmissao' é obrigatório.", 400);
        } else if (empty($name)) {
            throw new Exception("O campo 'nome_transmissao' não pode estar vazio.", 400);
        }

        // BUSCA TRANSMISSÃO
        $obTransmission = EntityTransmission::getTransmissionByName($name);

        // VALIDA SE A TRANSMISSÃO JÁ EXISTE
        if ($obTransmission instanceof EntityTransmission) {
            throw new Exception("Transmissão ".$name." já existente.", 400);
        }

        // CADASTRA UMA NOVA INSTÂNCIA NO BANCO
        $obTransmission = new EntityTransmission;
        $obTransmission->name = $name;
        $obTransmission->create();

        // RETORNA OS DETALHES DA TRANSMISSÃO CADASTRADA
        return [
            'id' => $obTransmission->id,
            'nome_marca' => $obTransmission->name,
            'success' => true
        ];
    }

    /**
     * Método responsável por atualizar uma transmissão
     * @param Request $request
     * @return array
     */
    public static function setEditTransmission($request, $id)
    {
        // VALIDA SE O ID É NUMERICO
        if (!is_numeric($id)) {
            throw new Exception("O id ".$id." não é válido.", 400);
        }

        // POST VARS
        $postVars = $request->getPostVars();

        // VALIDANDO CAMPO OBRIGATÓRIO
        if (!isset($postVars['nome_transmissao'])) {
            throw new Exception("O campo 'nome_transmissao' é obrigatório.", 400);
        }

        // BUSCA TRANSMISSÃO PELO NOME
        $obTransmissao = EntityTransmission::getTransmissionByName($postVars['nome_transmissao']);

        // VALIDA TRANSMISSÃO DUPLICADA
        if ($obTransmissao instanceof EntityTransmission) {
            throw new Exception("Transmissão ".$postVars['nome_transmissao']." já existente. Transmissão duplicada.", 400);
        }

        // BUSCA TRANSMISSÃO
        $obTransmissao = EntityTransmission::getTransmissionById($id);

        // VERIFICA SE O TRANSMISSÃO EXISTE
        if (!$obTransmissao instanceof EntityTransmission) {
            throw new Exception("A transmissão ".$id." não foi encontrada.", 404);
        }

        // VALIDANDO ALTERAÇÕES
        $obTransmissao->name = $postVars['nome_transmissao'] ?? $obTransmissao->name;

        // ATUALIZANDO INSTÂNCIA
        $obTransmissao->update();

        // RETORNA OS DETALHES DA TRANSMISSÃO ATUALIZADA
        return [
            'id'      => $obTransmissao->id,
            'success' => true
        ];
    }
}
