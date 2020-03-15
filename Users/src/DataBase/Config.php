<?php

use Phalcon\Config;

return new Config(
    [
        'database'    => [
            'adapter' => 'sqlite',
            'dbname'  => 'base.db',
        ],
        'application' => [
            'logInDb'              => true,
            'migrationsDir'        => __DIR__ . '/Migrations',
            'migrationsTsBased'    => true, // true - Use TIMESTAMP as version name, false - use versions (1.0.1)
            'exportDataFromTables' => [
                // Tables names
                // Attention! It will export data every new migration
            ],
        ],
    ]
);