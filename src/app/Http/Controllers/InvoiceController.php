<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class InvoiceController
{

    public function index(): void
    {
        echo 'Invoices';
    }

    public function create(): void
    {
        echo <<<Form
                <form action="\invoice" method="post">
                <label for="amount">Insert The invoice amount: </label>
                <input type="text" name="amount" id="amount">
                </form>
             Form;
    }

    public function store(): void
    {
        echo 'The amount is: ' . $_POST['amount'];
    }

}