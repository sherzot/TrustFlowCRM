<?php

use Illuminate\Support\Str;

return [
    'domain' => null,
    'path' => 'horizon',
    'use' => 'default',
    'prefix' => env('HORIZON_PREFIX', 'horizon'),
    'middleware' => ['web'],
    'waits' => [
        'redis:default' => 60,
    ],
    'trim' => [
        'recent' => 60,
        'pending' => 90,
        'completed' => 90,
        'recent_failed' => 90,
        'failed' => 90,
        'monitored' => 90,
    ],
    'environments' => [
        'production' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default'],
                'balance' => 'simple',
                'processes' => 10,
                'tries' => 3,
            ],
        ],
        'local' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default'],
                'balance' => 'simple',
                'processes' => 3,
                'tries' => 3,
            ],
        ],
    ],
];

