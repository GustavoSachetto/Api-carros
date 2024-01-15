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
            'autor'  => 'Gustavo Sachetto',
            'email'  => 'g.sachettocruz@gmail.com'
        ];
    }
}
