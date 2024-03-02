<?php

use App\Http\Response;
use App\Service;

$obRouter->get('/api/v1/transmissions', [
    'middlewares' => [
        'cache'
    ],
    function($request) {
        return new Response(200, Service\Transmission::getTransmissions($request));
    }
]);

$obRouter->get('/api/v1/transmissions/{id}', [
    function($request, $id) {
        return new Response(200, Service\Transmission::getTransmission($request, $id));
    }
]);

$obRouter->post('/api/v1/transmissions', [
    'middlewares' => [
        'jwt-auth'
    ],
    function($request) {
        return new Response(200, Service\Transmission::setNewTransmission($request));
    }
]);

$obRouter->put('/api/v1/transmissions/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function($request, $id) {
        return new Response(200, Service\Transmission::setEditTransmission($request, $id));
    }
]);

$obRouter->options('/api/v1/transmissions', [
    function($request) {
        return new Response(200, Service\Transmission::getDetails($request));
    }
]);

$obRouter->options('/api/v1/transmissions/{id}', [
    function($request) {
        return new Response(200, Service\Transmission::getDetails($request));
    }
]);