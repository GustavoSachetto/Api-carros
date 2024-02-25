<?php

use App\Http\Response;
use App\Service;

// ROTA DE COMBUSTIVEL DA API
$obRouter->get('/api/v1/fuels', [
    'middlewares' => [
        'cache'
    ],
    function($request) {
        return new Response(200, Service\Fuel::getFuels($request));
    }
]);

// ROTA DE CONSULTA DE COMBUSTIVEL
$obRouter->get('/api/v1/fuels/{id}', [
    function($request, $id) {
        return new Response(200, Service\Fuel::getFuel($request, $id));
    }
]);

// ROTA DE CADASTRO DE COMBUSTÍVEIS (POST)
$obRouter->post('/api/v1/fuels', [
    'middlewares' => [
        'user-basic-auth'
    ],
    function($request) {
        return new Response(200, Service\Fuel::setNewFuel($request));
    }
]);

// ROTA DE ATUALIZAÇÃO DE COMBUSTÍVEIS (PUT)
$obRouter->put('/api/v1/fuels/{id}', [
    'middlewares' => [
        'user-basic-auth',
        'user-admin-auth'
    ],
    function($request, $id) {
        return new Response(200, Service\Fuel::setEditFuel($request, $id));
    }
]);

// ROTA DE TESTE COMBUSTÍVEIS (OPTIONS)
$obRouter->options('/api/v1/fuels', [
    function($request) {
        return new Response(200, Service\Fuel::getDetails($request));
    }
]);

// ROTA DE TESTE COMBUSTÍVEIS ID (OPTIONS)
$obRouter->options('/api/v1/fuels/{id}', [
    function($request) {
        return new Response(200, Service\Fuel::getDetails($request));
    }
]);