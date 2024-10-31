<?php

use App\Http\Response;
use App\Controller\Api;

// Rota de busca de marcas
$obRouter->get('/api/v1/brands', [
    'middlewares' => [
        'cache'
    ],
    function ($request) {
        return new Response(200, Api\BrandController::get($request), 'application/json');
    }
]);

// Rota de procura de marca pelo id
$obRouter->get('/api/v1/brands/{id}', [
    function ($request, $id) {
        return new Response(200, Api\BrandController::fetch($request, $id), 'application/json');
    }
]);

// Rota de cadastro de marca
$obRouter->post('/api/v1/brands', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request) {
        return new Response(201, Api\BrandController::set($request), 'application/json');
    }
]);

// Rota de autorização de cadastro
$obRouter->options('/api/v1/brands', [
    function ($request) {
        return new Response(200, Api\BrandController::details($request), 'application/json');
    }
]);

// Rota de edição de marca pelo id
$obRouter->put('/api/v1/brands/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(201, Api\BrandController::edit($request, $id), 'application/json');
    }
]);

// Rota de autorização de edição
$obRouter->options('/api/v1/brands/{id}', [
    function ($request) {
        return new Response(200, Api\BrandController::details($request), 'application/json');
    }
]);

// Rota de exclusão de marca pelo id
$obRouter->delete('/api/v1/brands/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function ($request, $id) {
        return new Response(200, Api\BrandController::delete($request, $id), 'application/json');
    }
]);