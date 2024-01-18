<?php

use App\Service;
use App\Http\Response;

// ROTA DE USUÁRIOS DA API
$obRouter->get('/api/v1/users', [
    'middlewares' => [
        'user-basic-auth'
    ],
    function($request) {
        return new Response(200, Service\Api::getDetails($request));
    }
]);