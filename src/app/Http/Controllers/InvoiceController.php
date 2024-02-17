<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\View;
use App\Services\InvoiceService;

class InvoiceController
{

    public function __construct(protected InvoiceService $invoiceService)
    {
    }

    public function index(): View
    {
        $this->invoiceService->process([], 100);

        //        $email    = 'jane@example.com';
        //        $username = 'jane_doe';
        //        $amount   = 100;
        //
        //        $userModel    = new User();
        //        $invoiceModel = new Invoice();
        //
        //        $singUpModel = new SignUp($userModel, $invoiceModel);
        //
        //        $invoiceId = $singUpModel->register(
        //            [
        //                'email'    => $email,
        //                'username' => $username,
        //            ],
        //            [
        //                'amount' => $amount,
        //            ]
        //        );

        return View::make('/invoices/index', [
            //            'invoice' => $invoiceModel->find($invoiceId),
        ])->layout('app');
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