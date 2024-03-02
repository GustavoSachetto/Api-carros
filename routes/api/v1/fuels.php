<?php

use App\Http\Response;
use App\Service;

$obRouter->get('/api/v1/fuels', [
    'middlewares' => [
        'cache'
    ],
    function($request) {
        return new Response(200, Service\Fuel::getFuels($request));
    }
]);

$obRouter->get('/api/v1/fuels/{id}', [
    function($request, $id) {
        return new Response(200, Service\Fuel::getFuel($request, $id));
    }
]);

$obRouter->post('/api/v1/fuels', [
    'middlewares' => [
        'jwt-auth'
    ],
    function($request) {
        return new Response(200, Service\Fuel::setNewFuel($request));
    }
]);

$obRouter->put('/api/v1/fuels/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function($request, $id) {
        return new Response(200, Service\Fuel::setEditFuel($request, $id));
    }
]);

$obRouter->options('/api/v1/fuels', [
    function($request) {
        return new Response(200, Service\Fuel::getDetails($request));
    }
]);

$obRouter->options('/api/v1/fuels/{id}', [
    function($request) {
        return new Response(200, Service\Fuel::getDetails($request));
    }
]);