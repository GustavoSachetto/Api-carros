<?php

use App\Http\Response;
use App\Service;

$obRouter->get('/api/v1/cars', [
    'middlewares' => [
        'cache'
    ],
    function($request) {
        return new Response(200, Service\Car::getCars($request));
    }
]);

$obRouter->get('/api/v1/cars/{id}', [
    function($request, $id) {
        return new Response(200, Service\Car::getCar($request, $id));
    }
]);

$obRouter->post('/api/v1/cars', [
    'middlewares' => [
        'jwt-auth'
    ],
    function($request) {
        return new Response(200, Service\Car::setNewCar($request));
    }
]);

$obRouter->options('/api/v1/cars', [
    function($request) {
        return new Response(200, Service\Car::getDetails($request));
    }
]);