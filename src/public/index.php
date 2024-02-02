<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Config;
use App\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';

const VIEW_PATH = __DIR__ . '/../views';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

require_once __DIR__ . '/../app/Helpers/Functions.php';
require_once __DIR__ . '/../routes/web.php';

/** @var Router $router */
(new App($router, [
    'uri'    => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD'],
],
    new Config($_ENV)
))->run();