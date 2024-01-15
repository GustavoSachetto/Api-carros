<?php

use App\Http\Response;
use App\Service;

$obRouter->get('', [
    function($request) {
        return new Response(200, Service\Api::getDetails($request));
    }
]);