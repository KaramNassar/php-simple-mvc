<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\View;

class InvoiceController
{

    public function index(): View
    {
        return View::make('/invoices/index')->layout('app');
    }

    public function create(): View
    {
        return View::make('invoices/create')->layout('app');
    }

    public function store(): View
    {
        $amount = $_POST['amount'];

        return View::make('invoices/index', compact('amount'))->layout('app');
    }

}