<?php 

require __DIR__.'/includes/app.php';

use App\Http\Router;

// INICIA O ROUTER
$obRouter = new Router(URL);

// INCLUI AS ROTAS DA API
include __DIR__.'/routes/api.php';

// IMPRIME O RESPONSE DA ROTA
$obRouter->run()->sendReponse();