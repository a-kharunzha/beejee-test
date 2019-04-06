<?php declare(strict_types=1);

use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Narrowspark\HttpEmitter\EmitterInterface;
use Narrowspark\HttpEmitter\SapiEmitter;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

return [
    ServerRequestInterface::class => function () {
        return ServerRequestFactory::fromGlobals();
    },
    ResponseInterface::class => function () {
        return new Response;
    },
    Router::class => function (ContainerInterface $container) {
        $router = new Router;
        $strategy = new ApplicationStrategy;
        $strategy->setContainer($container);
        $router->setStrategy($strategy);
        require __DIR__ . '/routes.php';
        return $router;
    },
    EmitterInterface::class => function(){
        return new SapiEmitter;
    },
    Environment::class => function () {
        $loader = new FilesystemLoader(realpath(__DIR__ . '/../src/templates'));
        $twig = new Environment($loader, [
            'cache' => realpath(__DIR__ . '/../cache/twig'),
            'debug' => true
        ]);
        return $twig;
    },
];
