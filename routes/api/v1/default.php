<?php

use App\Http\Response;
use App\Service;

$obRouter->get('/api/v1', [
    function($request) {
        return new Response(200, Service\Api::getDetails($request));
    }
]);