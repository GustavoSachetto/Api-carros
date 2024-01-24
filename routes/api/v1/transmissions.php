<?php

use App\Http\Response;
use App\Service;

// ROTA DE TRANSMISSÃO DA API
$obRouter->get('/api/v1/transmissions', [
    function($request) {
        return new Response(200, Service\Transmission::getTransmissions($request));
    }
]);

// ROTA DE CONSULTA DE TRANSMISSÃO
$obRouter->get('/api/v1/transmissions/{id}', [
    function($request, $id) {
        return new Response(200, Service\Transmission::getTransmission($request, $id));
    }
]);

// ROTA DE CADASTRO DE TRANSMISSÃO (POST)
$obRouter->post('/api/v1/transmissions', [
    'middlewares' => [
        'user-basic-auth'
    ],
    function($request) {
        return new Response(200, Service\Transmission::setNewTransmission($request));
    }
]);

// ROTA DE ATUALIZAÇÃO DE TRANSMISSÃO (PUT)
$obRouter->put('/api/v1/transmissions/{id}', [
    'middlewares' => [
        'user-basic-auth',
        'user-admin-auth'
    ],
    function($request, $id) {
        return new Response(200, Service\Transmission::setEditTransmission($request, $id));
    }
]);

// ROTA DE TESTE TRANSMISSÃO (OPTIONS)
$obRouter->options('/api/v1/transmissions', [
    function($request) {
        return new Response(200, Service\Transmission::getDetails($request));
    }
]);

// ROTA DE TESTE TRANSMISSÃO ID (OPTIONS)
$obRouter->options('/api/v1/transmissions/{id}', [
    function($request) {
        return new Response(200, Service\Transmission::getDetails($request));
    }
]);