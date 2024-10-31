<?php

use App\Http\Response;
use App\Controller\Api;

// Rota de busca de modelos de veículos
$obRouter->get('/api/v1/carmodels', [
    'middlewares' => [
        'cache'
    ],
    function ($request) {
        return new Response(200, Api\CarmodelController::get($request), 'application/json');
    }
]);

// Rota de procura de modelo de veículo pelo id (marca)
$obRouter->get('/api/v1/carmodels/brand/{id}', [
    function ($request, $id) {
        return new Response(200, Api\CarmodelController::fetchBrand($request, $id), 'application/json');
    }
]);

// Rota de procura de modelo de veículo pelo id (modelo)
$obRouter->get('/api/v1/carmodels/model/{id}', [
    function ($request, $id) {
        return new Response(200, Api\CarmodelController::fetch($request, $id), 'application/json');
    }
]);

// Rota de cadastro de modelo de veículo
$obRouter->post('/api/v1/carmodels', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request) {
        return new Response(201, Api\CarmodelController::set($request), 'application/json');
    }
]);

// Rota de autorização de cadastro
$obRouter->options('/api/v1/carmodels', [
    function ($request) {
        return new Response(200, Api\CarmodelController::details($request), 'application/json');
    }
]);

// Rota de edição de modelo de veículo pelo id
$obRouter->put('/api/v1/carmodels/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(201, Api\CarmodelController::edit($request, $id), 'application/json');
    }
]);

// Rota de autorização de edição
$obRouter->options('/api/v1/carmodels/{id}', [
    function ($request) {
        return new Response(200, Api\CarmodelController::details($request), 'application/json');
    }
]);

// Rota de exclusão de modelo de veículo pelo id
$obRouter->delete('/api/v1/carmodels/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(200, Api\CarmodelController::delete($request, $id), 'application/json');
    }
]);