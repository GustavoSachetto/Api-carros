<?php

use App\Http\Response;
use App\Service;

// ROTA DE DETALHES DA API
$obRouter->get('/api/v1', [
    function($request) {
        return new Response(200, Service\Api::getDetails($request));
    }
]);