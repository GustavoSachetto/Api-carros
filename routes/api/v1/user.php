<?php

use App\Http\Response;
use App\Controller\Api;

// Rota de detalhes da api
$obRouter->get('/api/v1', [
    function ($request) {
        return new Response(200, Api\UserController::details($request), 'application/json');
    }
]);

// Rota de busca de usuários
$obRouter->get('/api/v1/users', [
    'middlewares' => [
        'basic-auth',
        'auth-admin',
        'cache'
    ],
    function ($request) {
        return new Response(200, Api\UserController::get($request), 'application/json');
    }
]);

// Rota de procura de usuário pelo id
$obRouter->get('/api/v1/users/{id}', [
    'middlewares' => [
        'basic-auth',
        'auth-admin'
    ],
    function ($request, $id) {
        return new Response(200, Api\UserController::fetch($request, $id), 'application/json');
    }
]);

// Rota de cadastro de usuário
$obRouter->post('/api/v1/users', [
    function ($request) {
        return new Response(201, Api\UserController::set($request), 'application/json');
    }
]);

// Rota de autorização de cadastro
$obRouter->options('/api/v1/users', [
    function ($request) {
        return new Response(200, Api\UserController::details($request), 'application/json');
    }
]);

// Rota de edição de usuário pelo id
$obRouter->put('/api/v1/users/{id}', [
    'middlewares' => [
        'basic-auth',
        'auth-admin'
    ],
    function ($request, $id) {
        return new Response(201, Api\UserController::edit($request, $id), 'application/json');
    }
]);

// Rota de autorização de edição
$obRouter->options('/api/v1/users/{id}', [
    function ($request) {
        return new Response(200, Api\UserController::details($request), 'application/json');
    }
]);

// Rota de exclusão de usuário pelo id
$obRouter->delete('/api/v1/users/{id}', [
    'middlewares' => [
        'basic-auth',
        'auth-admin'
    ],
    function ($request, $id) {
        return new Response(201, Api\UserController::delete($request, $id), 'application/json');
    }
]);