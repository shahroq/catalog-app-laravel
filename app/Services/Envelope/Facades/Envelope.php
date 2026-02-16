<?php

namespace App\Services\Envelope\Facades;

use App\Services\Envelope\Contracts\Envelope as EnvelopeContract;
use Illuminate\Support\Facades\Facade;

class Envelope extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        // return 'envelope';
        return EnvelopeContract::class;
    }
}
