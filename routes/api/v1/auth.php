<?php

use App\Http\Response;
use App\Service;

$obRouter->post('/api/v1/auth', [
    function($request) {
        return new Response(201, Service\Auth::generateToken($request));
    }
]);