<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        //'tns'            => 'tns_string',
        'tns' => '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.18.29.103)(PORT=1521)) (CONNECT_DATA=(SERVICE_NAME=devinfo)))',
        //'host'           => '10.18.29.103',
        //'port'           => '1521',
        'database'       => '',
        'username'       => 'ESZ',
        'password'       => 'wqKuq9LTKHH9uVs9',
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];
