<?php declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

// не использую yml, чтобы не дублировать доступы к БД в файле
return [
    "paths" => [
        "migrations" => realpath(__DIR__ . '/../db/migrations'),
        "seeds" => realpath(__DIR__ . '/../db/seeds'),
    ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => "dev",
        "dev" => [
            "adapter" => "mysql",
            "host" => $_ENV['DB_HOST'],
            "name" => $_ENV['DB_NAME'],
            "user" => $_ENV['DB_USER'],
            "pass" => $_ENV['DB_PASS'],
            "port" => $_ENV['DB_PORT']
        ]
    ]
];
