<?php

use App\Http\Response;
use App\Controller\Api;

// Rota de busca de veículos
$obRouter->get('/api/v1/cars', [
    'middlewares' => [
        'cache'
    ],
    function ($request) {
        return new Response(200, Api\CarController::get($request), 'application/json');
    }
]);

// Rota de procura de veículo pelo id
$obRouter->get('/api/v1/cars/{id}', [
    function ($request, $id) {
        return new Response(200, Api\CarController::fetch($request, $id), 'application/json');
    }
]);

// Rota de cadastro de veículo
$obRouter->post('/api/v1/cars', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request) {
        return new Response(201, Api\CarController::set($request), 'application/json');
    }
]);

// Rota de autorização de cadastro
$obRouter->options('/api/v1/cars', [
    function ($request) {
        return new Response(200, Api\CarController::details($request), 'application/json');
    }
]);

// Rota de edição de veículo pelo id
$obRouter->put('/api/v1/cars/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(201, Api\CarController::edit($request, $id), 'application/json');
    }
]);

// Rota de autorização de edição
$obRouter->options('/api/v1/cars/{id}', [
    function ($request) {
        return new Response(200, Api\CarController::details($request), 'application/json');
    }
]);

// Rota de exclusão de veículo pelo id
$obRouter->delete('/api/v1/cars/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(201, Api\CarController::delete($request, $id), 'application/json');
    }
]);