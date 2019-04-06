<?php declare(strict_types=1);


namespace App\Controller;

use App\View;
use Psr\Container\ContainerInterface;
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
        $this->response->getBody()->write(
            $this->renderView('task/add')
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
