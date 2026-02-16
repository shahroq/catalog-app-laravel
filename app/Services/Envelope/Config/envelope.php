<?php

return [
    'default' => env('ENVELOPE_DRIVER', 'jsend'),

    'drivers' => [
        'jsend' => [
            // JSend-specific config
            //
        ],
        'jsonapi' => [
            // JSON API-specific config
            'version' => '1.0',
        ],
    ],
];
