<?php

namespace App\Services\Envelope;

use App\Services\Envelope\Contracts\Envelope;
use App\Services\Envelope\Providers\JSendEnvelope;
use App\Services\Envelope\Providers\JsonApiEnvelope;
use Illuminate\Support\Manager;
use InvalidArgumentException;

class EnvelopeManager extends Manager
{
    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('envelope.default');
    }

    /**
     * Create JSend driver.
     */
    protected function createJsendDriver(): Envelope
    {
        return new JSendEnvelope;
    }

    /**
     * Create JSON API driver.
     */
    protected function createJsonapiDriver(): Envelope
    {
        return new JsonApiEnvelope;
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
            throw new InvalidArgumentException("Envelope driver [{$driver}] is not supported.");
        }
    }
}
