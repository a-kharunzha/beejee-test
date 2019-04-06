<?php declare(strict_types=1);


namespace App\Controller;

use App\View;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Model\Task as TaskModel;
use App\Exception\TaskInvalidArrayException;

class Task
{
    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    public function list(RequestInterface $request, $params): ResponseInterface
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

    public function add(RequestInterface $request): ResponseInterface
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

    protected function renderView(string $templateName, array $data = [])
    {
        /** @var View $view */
        $view = $this->container->make(View::class, [
            'fileName' => $templateName
        ]);
        return $view->render($data);
    }
}
