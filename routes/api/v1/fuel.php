<?php

use App\Http\Response;
use App\Service;

// ROTA DE COMBUSTIVEL DA API
$obRouter->get('/api/v1/fuels', [
    function($request) {
        return new Response(200, Service\Fuel::getFuels($request));
    }
]);

// ROTA DE CONSULTA DE COMBUSTIVEL
$obRouter->get('/api/v1/fuels/{id}', [
    function($request, $id) {
        return new Response(200, Service\Fuel::getFuel($request, $id));
    }
]);