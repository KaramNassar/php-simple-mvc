<?php

use App\Core\Router;
use App\Core\View;
use App\Http\Controllers\InvoiceController;

$router = new Router();

$router->get('/', function () {
    return View::make('index')->layout('app');
});

$router->get('/invoices', [InvoiceController::class, 'index']);
$router->get('/invoices/create', [InvoiceController::class, 'create']);
$router->post('/invoices', [InvoiceController::class, 'store']);
