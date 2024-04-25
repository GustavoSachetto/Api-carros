<?php

use App\Http\Response;
use App\Controller\Api;

// Rota de busca de token de autenticação
$obRouter->post('/api/v1/auth', [
    function ($request) {
        return new Response(201, Api\AuthController::get($request), 'application/json');
    }
]);

// Rota de autorização de busca
$obRouter->options('/api/v1/auth', [
    function($request) {
        return new Response(200, Api\AuthController::details($request));
    }
]);