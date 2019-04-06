<?php declare(strict_types=1);

use Dotenv\Dotenv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require_once(__DIR__ . '/../vendor/autoload.php');

// load environment from .env
$dotenv = Dotenv::create(dirname(__DIR__));
$dotenv->load();

/**
 * красивая страничка php-ошибок для разработки
 */
if (getenv('ENV') == 'dev') {
    $whoops = new Run;
    $whoops->pushHandler(new PrettyPageHandler);
    $whoops->register();
} else {
    /** @todo: set own error page?? */
}
//
require_once __DIR__ . '/active_record.php';
//
$containerBuilder = new DI\ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/config_di.php');
$containerBuilder->useAnnotations(true);
$container = $containerBuilder->build();
return $container;
