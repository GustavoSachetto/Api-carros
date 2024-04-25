<?php 

require __DIR__.'/includes/app.php';

use App\Http\Router;

$obRouter = new Router(URL);

include 'routes/api.php';

$obRouter->run()->sendReponse();