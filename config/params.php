<?php
return [
    'logger' => [
        'level' => getenv('LOG_LEVEL'),
        'path'  => getenv('LOG_PATH'),
    ],
    'providers' => [
        'first' => [
            'client' => \App\Client\First\FirstClient::class,
            'params' => [
                'url' => getenv('FIRST_PROVIDER_URL'),
                'secret' => getenv('FIRST_PROVIDER_SECRET'),
            ],
        ],
        'second' => [
            'client' => \App\Client\Second\SecondClient::class,
            'params' => [
                'url' => getenv('SECOND_PROVIDER_URL'),
                'secret' => getenv('SECOND_PROVIDER_SECRET'),
            ],
        ],
    ],
];