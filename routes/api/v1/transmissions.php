<?php

use App\Http\Response;
use App\Service;

// ROTA DE TRANSMISSÃO DA API
$obRouter->get('/api/v1/transmissions', [
    function($request) {
        return new Response(200, Service\Transmission::getTransmissions($request));
    }
]);

// ROTA DE CONSULTA DE TRANSMISSÃO
$obRouter->get('/api/v1/transmissions/{id}', [
    function($request, $id) {
        return new Response(200, Service\Transmission::getTransmission($request, $id));
    }
]);