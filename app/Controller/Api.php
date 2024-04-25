<?php

namespace App\Controller;

use App\Http\Request;
use App\Model\DatabaseManager\Pagination;

abstract class Api
{
    /**
     * Método responsável por retornar os detalhes da api
     */
    protected static function getDetails(): array
    {
        return [
            'name'    => 'API - api-carros',
            'version' => 'v1.0.0',
            'autor'   => 'Gustavo Sachetto da Cruz',
            'github'  => 'https://github.com/GustavoSachetto',
            'email'   => 'g.sachettocruz@gmail.com'
        ];
    }

    /**
     * Método responsável por retornar os detalhes da paginação
     */
    protected static function getPagination(Request $request, Pagination $obPagination): array
    {
        $queryParams = $request->getQueryParams();
        $pages       = $obPagination->getPages();

        return [
            'currentPage'       => isset($queryParams['page']) ? $queryParams['page'] : 1,
            'numberOfPages'     => !empty($pages) ? count($pages) : 1
        ];
    }
    
    /**
     * Método responsável por retornar os detalhes da api
     */
    public static function details(Request $request): array
    {
        return self::getDetails();
    }
}
