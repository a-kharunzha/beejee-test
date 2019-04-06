<?php


namespace App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Model\Task as TaskModel;

class Task
{
    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    public function list(RequestInterface $request): ResponseInterface
    {
        $list = TaskModel::find('all',['limit'=>3,'order'=>'id desc']);
        dump($list);
        exit();

        $this->response->getBody()->write('run list');
        return $this->response;
    }

    public function add(RequestInterface $request): ResponseInterface
    {
        $this->response->getBody()->write('run add');
        return $this->response;
    }
}
