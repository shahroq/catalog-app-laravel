<?php

namespace App\Services\Paymenta\Providers;

use App\Services\Paymenta\Contracts\Paymenta;

class StripePaymenta implements Paymenta
{
    public function process($amount): mixed
    {
        $result = ['Paymenta: Stripe proceeded with amount of '.$amount.'.'];

        return $result;
    }
}
