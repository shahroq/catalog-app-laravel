<?php

namespace App\Services\Paymenta\Providers;

use App\Services\Paymenta\Contracts\Paymenta;

class PaypalPaymenta implements Paymenta
{
    public function process($amount): mixed
    {
        $result = ['Paymenta: Paypal proceeded with amount of '.$amount.'.'];

        return $result;
    }
}
