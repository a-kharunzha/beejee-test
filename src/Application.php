<?php


namespace App;


use Psr\Http\Message\ServerRequestInterface;

class Application
{
    /**
     * @Inject
     * @var ServerRequestInterface
     */
    protected $request;

    public function run()
    {
        echo 'app is running by uri '.$this->request->getUri();
    }
}
