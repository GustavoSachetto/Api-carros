<?php

use App\Service;
use App\Http\Response;

$obRouter->get('/api/v1/users', [
    'middlewares' => [
        'user-basic-auth',
        'admin-auth',
        'cache'
    ],
    function($request) {
        return new Response(200, Service\User::getUsers($request));
    }
]);

$obRouter->get('/api/v1/users', [
    'middlewares' => [
        'user-basic-auth',
        'admin-auth',
        'cache'
    ],
    function($request) {
        return new Response(200, Service\User::getUsers($request));
    }
]);

$obRouter->get('/api/v1/users/{id}', [
    'middlewares' => [
        'user-basic-auth',
        'admin-auth',
    ],
    function($request, $id) {
        return new Response(200, Service\User::getUser($request, $id));
    }
]);

$obRouter->post('/api/v1/users', [
    'middlewares' => [
        'user-basic-auth',
        'admin-auth'
    ],
    function($request) {
        return new Response(200, Service\User::setNewUser($request));
    }
]);

$obRouter->put('/api/v1/users/{id}', [
    'middlewares' => [
        'user-basic-auth',
        'admin-auth'
    ],
    function($request, $id) {
        return new Response(200, Service\User::setEditUser($request, $id));
    }
]);

$obRouter->delete('/api/v1/users/{id}', [
    'middlewares' => [
        'user-basic-auth',
        'admin-auth'
    ],
    function($request, $id) {
        return new Response(200, Service\User::setDeleteUser($request, $id));
    }
]);

$obRouter->options('/api/v1/users', [
    function($request) {
        return new Response(200, Service\User::getDetails($request));
    }
]);

$obRouter->options('/api/v1/users/{id}', [
    function($request) {
        return new Response(200, Service\User::getDetails($request));
    }
]);