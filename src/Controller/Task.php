<?php declare(strict_types=1);


namespace App\Controller;

use App\Controller;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use App\Model\Task as TaskModel;
use App\Exception\TaskInvalidArrayException;
use Psr\Http\Message\ServerRequestInterface;

class Task extends Controller
{
    public function list(ServerRequestInterface $request, $params): ResponseInterface
    {
        $list = TaskModel::findListByRequestParams($params);
        $paginator = TaskModel::makePaginatorByRequestParams($params);
        $this->response->getBody()->write(
            $this->renderView('task/list', [
                'list' => $list,
                'paginator'=>$paginator
            ])
        );
        return $this->response;
    }

    public function add(ServerRequestInterface $request): ResponseInterface
    {
        $data = [];
        $data['values'] = $request->getParsedBody();
        if($data['values']['save']){
            try {
                $newTask = TaskModel::initFromArray($data['values']);
                $newTask->save();
                // @todo: show message after redirect, saving flash data in session
                $data['message'] = 'Task is created successfully';
                $data['values'] = [];
            } catch (TaskInvalidArrayException $e) {
                $data['errors'] = $e->getErrors();
            }
        }
        $this->response->getBody()->write(
            $this->renderView('task/add',$data)
        );
        return $this->response;
    }

    public function edit(ServerRequestInterface $request, $params): ResponseInterface
    {
        // must be int
        $params['id'] = (int)$params['id'];
        // check if such task exists
        $task = TaskModel::find([$params['id']]);
        if(!$task){
            throw new NotFoundException();
        }
        $data = [];
        $data['values'] = $request->getParsedBody();
        $data['values']['id'] = $task->id;
        if($data['values']['save']){
            try {
                $newTask = TaskModel::initFromArray($data['values']);
                $newTask->save();
                // @todo: show message after redirect, saving flash data in session
                $data['message'] = 'Task is updated successfully';
            } catch (TaskInvalidArrayException $e) {
                $data['errors'] = $e->getErrors();
            }
        }else{
            $data['values'] = $task;
        }
        $this->response->getBody()->write(
            $this->renderView('task/edit',$data)
        );
        return $this->response;
    }
}
