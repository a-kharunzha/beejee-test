<?php declare(strict_types=1);

use App\Application;

$container = require_once __DIR__ . '/../config/bootstrap.php';

/** @var App\Application $app */
$app = $container->get(Application::class);

$app->run();
