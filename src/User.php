<?php


namespace App;


use App\Exception\AuthException;
use Zend\Session\Container as SessionContainer;

class User
{
    /**
     * @var SessionContainer
     */
    private $session;

    public function __construct(SessionContainer $session)
    {
        $this->session = $session;

    }

    /**
     * @param $login
     * @param $pass
     *
     * @throws AuthException
     */
    public function auth($login, $pass)
    {
        if (
            $login != getenv('ADMIN_LOGIN')
            ||
            $pass != getenv('ADMIN_PASS')
        ) {
            // if it will be necessary, [] can be used to show more detailed errors for each field
            throw new AuthException('Invalid login or pass', []);
        }
        $this->session['auth'] = true;
    }

    public function logout()
    {
        $this->session['auth'] = false;
    }

    public function isAuthorized()
    {
        return $this->session['auth'];
    }
}
