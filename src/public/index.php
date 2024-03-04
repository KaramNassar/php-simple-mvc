<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Container;
use App\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/Functions.php';

const VIEW_PATH = __DIR__ . '/../views';

$container = new Container();
$router    = new Router($container);

require_once __DIR__ . '/../routes/web.php';
/** @var Router $router */
(new App(
    $container,
    $router,
    [
        'uri'    => $_SERVER['REQUEST_URI'],
        'method' => $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'],
    ]
))->boot()->run();
