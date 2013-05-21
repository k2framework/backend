<?php

namespace K2\Backend\Controller;

use K2\Kernel\App;
use K2\Security\Security;
use K2\Kernel\Controller\Controller;

/**
 * Description of IndexController
 *
 * @author manuel
 */
class indexController extends Controller {

    protected function beforeFilter() {
        $this->limitParams = false;
    }

    public function index_action() {
        return $this->getRouter()->forward('@K2Backend/usuarios/index');
    }

    public function login_action() {
        $this->setView('@K2Backend/login');
        if (App::get('session')->has(Security::LOGIN_ERROR)) {
            App::get('flash')->error(App::get('session')->get(Security::LOGIN_ERROR));
            App::get('session')->delete(Security::LOGIN_ERROR);
        }
    }

}