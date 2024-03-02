<?php

require __DIR__.'/../vendor/autoload.php';

use App\Common\Environment;
use App\Model\DatabaseManager\Database;
use App\Http\Middleware\Queue as MiddlewareQueue;

Environment::load(__DIR__.'/../');

Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'), 
    getenv('DB_PORT')
);

define('URL', getenv('URL'));

MiddlewareQueue::setMap([
    'maintenance'     => \App\Http\Middleware\Maintenance::class,
    'user-basic-auth' => \App\Http\Middleware\UserBasicAuth::class,
    'admin-auth'      => \App\Http\Middleware\AdminAuth::class,
    'jwt-auth'        => \App\Http\Middleware\JWTAuth::class,
    'cache'           => \App\Http\Middleware\Cache::class
]);

MiddlewareQueue::setDefault([
    'maintenance'
]);