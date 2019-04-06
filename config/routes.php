<?php declare(strict_types=1);

/** @var League\Route\Router $router */

// map a routes
use App\Controller\Task;

$router->get('/', [Task::class,'list']);
$router->get('/add/', [Task::class, 'add']);
