<?php

return [
    'default' => env('PAYMENTA_DRIVER', 'paypal'),

    'drivers' => [
        'paypal' => [
            // Paypal-specific config
            'version' => '1.0',
        ],
        'stripe' => [
            // Stripe-specific config
            'version' => '1.0',
        ],
    ],
];
