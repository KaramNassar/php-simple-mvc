<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/Functions.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const VIEW_PATH = __DIR__ . '/../views';

require_once __DIR__ . '/../routes/web.php';

/** @var Router $router */
(new App($router, [
    'uri'    => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD'],
]))->run();