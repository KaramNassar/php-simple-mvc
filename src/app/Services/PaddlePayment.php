<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;

class PaddlePayment implements PaymentGatewayInterface
{

    public function charge(array $customer, float $amount, float $tax): bool
    {
        echo 'Charging from Paddle <br>';

        return true;
    }

}