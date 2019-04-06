<?php


namespace App;


use App\Exception\UserOverridedException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class Controller
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

    /**
     * @Inject
     * @var User
     */
    protected $user;

    /**
     * @param string $templateName
     * @param array $data
     *
     * @return string
     * @throws UserOverridedException
     */
    protected function renderView(string $templateName, array $data = [])
    {
        if(isset($data['user'])){
            throw new UserOverridedException('Field user in view data is reserved');
        }
        $data['user'] = $this->user;
        /** @var View $view */
        $view = $this->container->make(View::class, [
            'fileName' => $templateName
        ]);
        return $view->render($data);
    }
}
