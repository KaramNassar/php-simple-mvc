<?php

declare(strict_types=1);

use App\Core\Router;
use App\Core\View;
use App\Exceptions\RouteNotFoundException;
use App\Http\Controllers\InvoiceController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/Functions.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const VIEW_PATH = __DIR__ . '/../views';

$router = new Router();

$router->get('/', function () {
    return View::make('index')->layout('app');
});

$router->get('/invoices', [InvoiceController::class, 'index']);
$router->get('/invoices/create', [InvoiceController::class, 'create']);
$router->post('/invoices', [InvoiceController::class, 'store']);

try {
    echo $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (RouteNotFoundException $e) {
    echo $e->getMessage();
}