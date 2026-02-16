<?php

namespace App\Services\Paymenta\Contracts;

interface Paymenta
{
    public function process($amount): mixed;
}
