<?php
return [
    'logger' => [
        'level' => getenv('LOG_LEVEL'),
        'path'  => getenv('LOG_PATH'),
    ],
];