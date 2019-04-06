<?php declare(strict_types=1);

ActiveRecord\Config::initialize(function (ActiveRecord\Config $cfg) {
    $dsn = sprintf('mysql://%s:%s@%s:%u/%s',
        $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_HOST'], $_ENV['DB_PORT'], $_ENV['DB_NAME']);
    $cfg->set_model_directory(realpath(__DIR__ . '/../src/Model'));
    $cfg->set_connections(
        array(
            'dev' => $dsn,
            'prod' => $dsn,
        )
    );
    $cfg->set_default_connection($_ENV['ENV']);
});
