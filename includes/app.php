<?php

require __DIR__.'/../vendor/autoload.php';

use App\Common\Environment;
use App\Model\DatabaseManager\Database;
use App\Http\Middleware\Queue as MiddlewareQueue;

// CARREGA AS VARIAVEIS DE AMBIENTE
Environment::load(__DIR__.'/../');

// DEFINE AS CONFIGURAÇÕES DE BANDO DE DADOS
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'), 
    getenv('DB_PORT')
);

// DEFINE CONSTANTE DE URL
define('URL', getenv('URL'));

// DEFINE O MAPEAMENTO DE MIDDLEWARES
MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class,
    'user-basic-auth' => \App\Http\Middleware\UserBasicAuth::class,
    'user-admin-auth' => \App\Http\Middleware\UserAdminAuth::class,
    'cache' => \App\Http\Middleware\Cache::class
]);

// DEFINE O MAPEAMENTO DE MIDDLEWARES PADRÕES
MiddlewareQueue::setDefault([
    'maintenance'
]);