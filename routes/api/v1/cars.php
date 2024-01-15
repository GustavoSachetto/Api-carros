<?php

use App\Http\Response;
use App\Service;

// ROTA DE VEÍCULOS DA API
$obRouter->get('/api/v1/cars', [
    function($request) {
        return new Response(200, Service\Car::getCars($request));
    }
]);