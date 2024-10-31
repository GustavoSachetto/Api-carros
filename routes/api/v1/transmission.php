<?php

use App\Http\Response;
use App\Controller\Api;

// Rota de busca de transmissões
$obRouter->get('/api/v1/transmissions', [
    'middlewares' => [
        'cache'
    ],
    function ($request) {
        return new Response(200, Api\TransmissionController::get($request), 'application/json');
    }
]);

// Rota de procura de transmissão pelo id
$obRouter->get('/api/v1/transmissions/{id}', [
    function ($request, $id) {
        return new Response(200, Api\TransmissionController::fetch($request, $id), 'application/json');
    }
]);

// Rota de cadastro de transmissão
$obRouter->post('/api/v1/transmissions', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request) {
        return new Response(201, Api\TransmissionController::set($request), 'application/json');
    }
]);

// Rota de autorização de cadastro
$obRouter->options('/api/v1/transmissions', [
    function ($request) {
        return new Response(200, Api\TransmissionController::details($request), 'application/json');
    }
]);

// Rota de edição de transmissão pelo id
$obRouter->put('/api/v1/transmissions/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(201, Api\TransmissionController::edit($request, $id), 'application/json');
    }
]);

// Rota de autorização de edição
$obRouter->options('/api/v1/transmissions/{id}', [
    function ($request) {
        return new Response(200, Api\TransmissionController::details($request), 'application/json');
    }
]);

// Rota de exclusão de transmissão pelo id
$obRouter->delete('/api/v1/transmissions/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(200, Api\TransmissionController::delete($request, $id), 'application/json');
    }
]);