<?php


namespace App\Controller;


use App\Controller;
use App\Exception\AuthException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class User extends Controller
{
    public function login(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->user->isAuthorized()) {
            return new RedirectResponse('/');
        }
        $data = [];
        $data['values'] = $request->getParsedBody();
        if ($data['values']['auth']) {
            try {
                $this->user->auth($data['values']['login'], $data['values']['password']);
                return new RedirectResponse('/');
            } catch (AuthException $e) {
                $data['errors'] = $e->getErrors();
                $data['errors']['total'] = $e->getMessage();
            }
        }
        $this->response->getBody()->write(
            $this->renderView('user/login', $data)
        );
        return $this->response;
    }

    public function logout(ServerRequestInterface $request): ResponseInterface
    {
        $this->user->logout();
        return new RedirectResponse('/');
    }
}
