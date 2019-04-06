<?php


namespace App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Task
{
    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    public function list(RequestInterface $request): ResponseInterface
    {
        $this->response->getBody()->write('run list');
        return $this->response;
    }

    public function add(RequestInterface $request): ResponseInterface
    {
        $this->response->getBody()->write('run add');
        return $this->response;
    }
}
