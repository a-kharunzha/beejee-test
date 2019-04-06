<?php declare(strict_types=1);

/** @var League\Route\Router $router */

// map a routes
use App\Controller\Task;

$router->get('/add/', [Task::class, 'add']);
$router->post('/add/', [Task::class, 'add']);
$router->get('/', [Task::class, 'list']);
$router->get('/{page:number}/', [Task::class, 'list']);
$router->get('/{sort:word}/', [Task::class, 'list']);
$router->get('/{sort:word}/{page:number}/', [Task::class, 'list']);
$router->get('/{sort:word}/{dir:word}/', [Task::class, 'list']);
$router->get('/{sort:word}/{dir:word}/{page:number}/', [Task::class, 'list']);
