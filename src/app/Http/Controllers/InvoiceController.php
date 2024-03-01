<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Attributes\Get;
use App\Core\Attributes\Post;
use App\Core\Attributes\Put;
use App\Core\View;
use App\Models\Invoice;
use App\Services\InvoiceService;

class InvoiceController
{

    public function __construct(protected InvoiceService $invoiceService)
    {
    }

    #[Get('/invoices')]
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

    #[Get('/invoices/create')]
    public function create(): View
    {
        return View::make('invoices/create')->layout('app');
    }

    #[Post('/invoices')]
    public function store(): View
    {
        $amount = $_POST['amount'];

        return View::make('invoices/index', compact('amount'))->layout('app');
    }

    #[Get('/invoices/edit')]
    public function edit(int $id = 1): View
    {
        $invoiceModel = (new Invoice())->find($id);

        return View::make('invoices/edit')->layout('app');
    }

    #[Put('/invoices')]
    public function update(): string
    {
        return 'Invoice has been updated';
    }

}