<?php

declare(strict_types=1);

use App\Core\Router;
use App\Exceptions\RouteNotFoundException;
use App\Http\Controllers\InvoiceController;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->get('/', function () {
    echo 'Home';
});

$router->get('/invoice', [InvoiceController::class, 'create']);
$router->post('/invoice', [InvoiceController::class, 'store']);

try {
    $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (RouteNotFoundException $e) {
    echo $e->getMessage();
}