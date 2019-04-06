<?php


namespace App;


use League\Route\Router;
use Narrowspark\HttpEmitter\EmitterInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application
{
    /**
     * @Inject
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var Router
     */
    protected $router;

    /**
     * @Inject
     * @var EmitterInterface
     */
    protected $emitter;

    public function run()
    {
        // echo 'run app by url '.$this->request->getUri();
        $response = $this->router->dispatch($this->request);
        $this->emitter->emit($response);
    }
}
