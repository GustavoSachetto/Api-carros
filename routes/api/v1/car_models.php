<?php

use App\Http\Response;
use App\Service;

// ROTA DE MODELO DE VEÍCULOS DA API
$obRouter->get('/api/v1/carmodels', [
    function($request) {
        return new Response(200, Service\CarModel::getCarModels($request));
    }
]);

// ROTA DE CONSULTA MODELO DE VEÍCULOS
$obRouter->get('/api/v1/carmodels/{id}', [
    function($request, $id) {
        return new Response(200, Service\CarModel::getCarModel($request, $id));
    }
]);

// ROTA DE CADASTRO DE MODELO DE VEÍCULOS (POST)
$obRouter->post('/api/v1/carmodels', [
    function($request) {
        return new Response(200, Service\CarModel::setNewCarModel($request));
    }
]);

// ROTA DE TESTE CADASTRO DE MODELO (OPTIONS)
$obRouter->options('/api/v1/carmodels', [
    function($request) {
        return new Response(200, Service\CarModel::getDetails($request));
    }
]);