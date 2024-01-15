<?php

namespace App\Service;

class Api
{
     /**
     * Método reponsável por retornar os detalhes da API
     * @param Request $request
     * @return array
     */
    public static function getDetails($request)
    {
        return [
            'nome'   => 'API - Api-carros',
            'versao' => 'v1.0.0',
            'autor'  => 'Gustavo Sachetto da Cruz',
            'email'  => 'g.sachettocruz@gmail.com'
        ];
    }

    /**
     * Método responsável por retornar os detalhes da paginação
     * @param Request $request
     * @param Pagination $obPagination
     * @return array
     */
    protected static function getPagination($request, $obPagination)
    {
        // QUERY PARAMS
        $queryParams = $request->getQueryParams();

        // PÁGINA 
        $pages = $obPagination->getPages();

        // RETORNO
        return [
            'paginaAtual'       => isset($queryParams['page']) ? $queryParams['page']: 1,
            'quantidadePaginas' => !empty($pages) ? count($pages)        : 1
        ];
    }
}
