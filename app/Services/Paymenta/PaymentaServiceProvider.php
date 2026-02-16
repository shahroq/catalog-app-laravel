<?php

namespace App\Services\Paymenta;

use App\Services\Paymenta\Contracts\Paymenta;
use App\Services\Paymenta\Providers\PaypalPaymenta;
use App\Services\Paymenta\Providers\StripePaymenta;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class PaymentaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // no Swiping
        // $this->app->singleton(Paymenta::class, PaypalPaymenta::class);

        // Swiping with Manager
        // $this->app->singleton(Paymenta::class, fn (Application $app) => new PaymentaManager($app));

        // Swiping with
        $this->app->singleton(
            Paymenta::class,
            function (Application $app) {
                $driver = config('paymenta.default');

                return match ($driver) {
                    'paypal' => $app->make(PaypalPaymenta::class),
                    'stripe' => $app->make(StripePaymenta::class),
                    default => throw new InvalidArgumentException(
                        "Paymenta driver [{$driver}] is not supported."
                    ),
                };
            }
        );

    }

    public function boot(): void
    {
        $path = __DIR__.'/Config/paymenta.php';
        $this->publishes([$path => config_path('paymenta.php')], 'config');
    }
}
