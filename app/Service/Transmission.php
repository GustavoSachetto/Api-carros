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
        // ITENS
        $itens = [];

        // RESULTADOS DA PÁGINA
        $results = EntityTransmission::getTransmissions(null,'id ASC');

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
            'nome_transmissao' => $obTransmission->nome_transmissao
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
        $nome = $postVars['nome_transmissao'] ?? null;

        // VALIDA O NOME
        if (!isset($nome)) {
            throw new Exception("O campo 'nome_transmissao' é obrigatório.", 400);
        } else if (empty($nome)) {
            throw new Exception("O campo 'nome_transmissao' não pode estar vazio.", 400);
        }

        // BUSCA TRANSMISSÃO
        $obTransmission = EntityTransmission::getTransmissionByName($nome);

        // VALIDA SE A TRANSMISSÃO JÁ EXISTE
        if ($obTransmission instanceof EntityTransmission) {
            throw new Exception("Transmissão ".$nome." já existente.", 400);
        }

        // CADASTRA UMA NOVA INSTÂNCIA NO BANCO
        $obTransmission = new EntityTransmission;
        $obTransmission->nome_transmissao = $nome;
        $obTransmission->cadastrar();

        // RETORNA OS DETALHES DA TRANSMISSÃO CADASTRADA
        return [
            'id' => $obTransmission->id,
            'nome_marca' => $obTransmission->nome_transmissao,
            'success' => true
        ];
    }
}
