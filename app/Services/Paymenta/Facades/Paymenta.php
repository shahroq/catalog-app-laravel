<?php

namespace App\Services\Paymenta\Facades;

use App\Services\Paymenta\Contracts\Paymenta as ContractsPaymenta;
use Illuminate\Support\Facades\Facade;

class Paymenta extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ContractsPaymenta::class;
    }
}
