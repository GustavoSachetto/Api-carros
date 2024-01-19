<?php

use App\Service;
use App\Http\Response;

// ROTA DE USUÁRIOS DA API
$obRouter->get('/api/v1/users', [
    'middlewares' => [
        'user-basic-auth',
        'user-admin-auth'
    ],
    function($request) {
        return new Response(200, Service\User::getUsers($request));
    }
]);

// ROTA DE CONSULTA DE USUÁRIO PELO ID
$obRouter->get('/api/v1/users/{id}', [
    'middlewares' => [
        'user-basic-auth',
        'user-admin-auth'
    ],
    function($request, $id) {
        return new Response(200, Service\User::getUser($request, $id));
    }
]);

// ROTA DE CADASTRO DE USUÁRIOS
$obRouter->post('/api/v1/users', [
    'middlewares' => [
        'user-basic-auth',
        'user-admin-auth'
    ],
    function($request) {
        return new Response(200, Service\User::setNewUser($request));
    }
]);