<?php

use App\Http\Response;
use App\Controller\Api;

// Rota de busca de combustíveis
$obRouter->get('/api/v1/fuels', [
    'middlewares' => [
        'cache'
    ],
    function ($request) {
        return new Response(200, Api\FuelController::get($request), 'application/json');
    }
]);

// Rota de procura de combustível pelo id
$obRouter->get('/api/v1/fuels/{id}', [
    function ($request, $id) {
        return new Response(200, Api\FuelController::fetch($request, $id), 'application/json');
    }
]);

// Rota de cadastro de combustível
$obRouter->post('/api/v1/fuels', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request) {
        return new Response(201, Api\FuelController::set($request), 'application/json');
    }
]);

// Rota de autorização de cadastro
$obRouter->options('/api/v1/fuels', [
    function ($request) {
        return new Response(200, Api\FuelController::details($request), 'application/json');
    }
]);

// Rota de edição de combustível pelo id
$obRouter->put('/api/v1/fuels/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(201, Api\FuelController::edit($request, $id), 'application/json');
    }
]);

// Rota de autorização de edição
$obRouter->options('/api/v1/fuels/{id}', [
    function ($request) {
        return new Response(200, Api\FuelController::details($request), 'application/json');
    }
]);

// Rota de exclusão de combustível pelo id
$obRouter->delete('/api/v1/fuels/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(201, Api\FuelController::delete($request, $id), 'application/json');
    }
]);