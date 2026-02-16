<?php

namespace App\Services\Paymenta;

use App\Services\Paymenta\Contracts\Paymenta;
use App\Services\Paymenta\Providers\PaypalPaymenta;
use App\Services\Paymenta\Providers\StripePaymenta;
use Illuminate\Support\Manager;
use InvalidArgumentException;

class PaymentaManager extends Manager
{
    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('paymenta.default');
    }

    /**
     * Create Paypal driver.
     */
    protected function createPaypalDriver(): Paymenta
    {
        return new PaypalPaymenta;
    }

    /**
     * Create Paypal driver.
     */
    protected function createStripeDriver(): Paymenta
    {
        return new StripePaymenta;
    }

    // Add more createXxxDriver() methods for other standards

    /**
     * Handle missing drivers.
     */
    protected function createDriver($driver): mixed
    {
        try {
            return parent::createDriver($driver);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException("Paymenta driver [{$driver}] is not supported.");
        }
    }
}
