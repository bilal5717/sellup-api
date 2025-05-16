<?php

return [
    'default' => env('FILESYSTEM_DISK', 'r2'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],
        
        
    'r2' => [
        'driver' => 's3',
        'url' => env('R2_PUBLIC_URL', 'https://pub-abee2d9478719c925e185ad42ebd59fb.r2.dev'),
        'key' => env('R2_ACCESS_KEY_ID'),
        'secret' => env('R2_SECRET_ACCESS_KEY'),
        'region' => 'auto',
        'bucket' => env('R2_BUCKET'),
        'endpoint' => env('R2_ENDPOINT'),
        'use_path_style_endpoint' => true,
    ],

    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];