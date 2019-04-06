<?php declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

return [
    ServerRequestInterface::class => function () {
        return ServerRequestFactory::fromGlobals();
    },
    ResponseInterface::class => function () {
        return new Response;
    }
];
