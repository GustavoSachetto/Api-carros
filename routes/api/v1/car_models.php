<?php

use App\Http\Response;
use App\Service;

$obRouter->get('/api/v1/carmodels', [
    'middlewares' => [
        'cache'
    ],
    function($request) {
        return new Response(200, Service\CarModel::getCarModels($request));
    }
]);

$obRouter->get('/api/v1/carmodels/bycarmodels/{id}', [
    function($request, $id) {
        return new Response(200, Service\CarModel::getCarModel($request, $id));
    }
]);

$obRouter->get('/api/v1/carmodels/bybrand/{id}', [
    'middlewares' => [
        'cache'
    ],
    function($request, $id) {
        return new Response(200, Service\CarModel::getCarModelsByBrand($request, $id));
    }
]);

$obRouter->post('/api/v1/carmodels', [
    'middlewares' => [
        'jwt-auth'
    ],
    function($request) {
        return new Response(200, Service\CarModel::setNewCarModel($request));
    }
]);

$obRouter->put('/api/v1/carmodels/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function($request, $id) {
        return new Response(200, Service\CarModel::setEditCarModel($request, $id));
    }
]);

$obRouter->options('/api/v1/carmodels', [
    function($request) {
        return new Response(200, Service\CarModel::getDetails($request));
    }
]);

$obRouter->options('/api/v1/carmodels/{id}', [
    function($request) {
        return new Response(200, Service\CarModel::getDetails($request));
    }
]);