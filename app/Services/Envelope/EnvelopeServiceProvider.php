<?php

namespace App\Services\Envelope;

use App\Services\Envelope\Contracts\Envelope;
use App\Services\Envelope\Providers\JSendEnvelope;
use App\Services\Envelope\Providers\JsonApiEnvelope;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class EnvelopeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            Envelope::class,
            function (Application $app) {
                $driver = config('envelope.default');

                return match ($driver) {
                    'jsend' => $app->make(JSendEnvelope::class),
                    'jsonapi' => $app->make(JsonApiEnvelope::class),
                    default => throw new InvalidArgumentException(
                        "Envelope driver [{$driver}] is not supported."
                    ),
                };
            }
        );
    }

    public function boot(): void
    {
        $path = __DIR__.'/Config/envelope.php';
        $this->publishes([$path => config_path('envelope.php')], 'config');
    }
}
