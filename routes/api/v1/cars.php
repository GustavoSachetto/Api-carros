<?php

use App\Http\Response;
use App\Service;

// ROTA DE VEÍCULOS DA API
$obRouter->get('/api/v1/cars', [
    function($request) {
        return new Response(200, Service\Car::getCars($request));
    }
]);

// ROTA DE CONSULTA DE VEÍCULOS
$obRouter->get('/api/v1/cars/{id}', [
    function($request, $id) {
        return new Response(200, Service\Car::getCar($request, $id));
    }
]);

// ROTA DE CADASTRO DE VEÍCULOS (POST)
$obRouter->post('/api/v1/cars', [
    'middlewares' => [
        'user-basic-auth'
    ],
    function($request) {
        return new Response(200, Service\Car::setNewCar($request));
    }
]);

// ROTA DE TESTE DE VEÍCULOS (OPTIONS)
$obRouter->options('/api/v1/cars', [
    function($request) {
        return new Response(200, Service\Car::getDetails($request));
    }
]);