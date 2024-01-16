<?php

use App\Http\Response;
use App\Service;

// ROTA DE MARCA DA API
$obRouter->get('/api/v1/brands', [
    function($request) {
        return new Response(200, Service\Brand::getBrands($request));
    }
]);

// ROTA DE CONSULTA DE MARCA
$obRouter->get('/api/v1/brands/{id}', [
    function($request, $id) {
        return new Response(200, Service\Brand::getBrand($request, $id));
    }
]);