<?php

use App\Core\Router;
use App\Core\View;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;

/** @var Router $router */
$router->registerRoutesFromControllerAttributes([
    HomeController::class,
    InvoiceController::class,
    UserController::class
]);

//
//$router->get('/', function () {
//    return View::make('index')->layout('app');
//});
//
//$router->get('/invoices', [InvoiceController::class, 'index']);
//$router->get('/invoices/create', [InvoiceController::class, 'create']);
//$router->post('/invoices', [InvoiceController::class, 'store']);
