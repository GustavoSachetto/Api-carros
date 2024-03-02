<?php

use App\Http\Response;
use App\Service;

$obRouter->get('/api/v1/brands', [
    'middlewares' => [
        'cache'
    ],
    function($request) {
        return new Response(200, Service\Brand::getBrands($request));
    }
]);

$obRouter->get('/api/v1/brands/{id}', [
    function($request, $id) {
        return new Response(200, Service\Brand::getBrand($request, $id));
    }
]);

$obRouter->post('/api/v1/brands', [
    'middlewares' => [
        'jwt-auth'
    ],
    function($request) {
        return new Response(200, Service\Brand::setNewBrand($request));
    }
]);

$obRouter->put('/api/v1/brands/{id}', [
    'middlewares' => [
        'jwt-auth'
    ],
    function($request, $id) {
        return new Response(200, Service\Brand::setEditBrand($request, $id));
    }
]);

$obRouter->options('/api/v1/brands', [
    function($request) {
        return new Response(200, Service\Brand::getDetails($request));
    }
]);

$obRouter->options('/api/v1/brands/{id}', [
    function($request) {
        return new Response(200, Service\Brand::getDetails($request));
    }
]);