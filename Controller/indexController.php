<?php

namespace K2\Backend\Controller;

use KumbiaPHP\Security\Security;
use KumbiaPHP\Kernel\Controller\Controller;

/**
 * Description of IndexController
 *
 * @author manuel
 */
class indexController extends Controller {

    protected function beforeFilter() {
        if ($this->getRequest()->isAjax()) {
            $this->setTemplate(NULL);
        } else {
            $this->setTemplate('K2/Backend:login');
        }
        $this->limitParams = false;
    }

    public function index_action() {
        return $this->getRouter()->forward('K2/Backend:usuarios/index');
    }

    public function login_action() {
        $this->setView(null);
        if ($this->get('session')->has(Security::LOGIN_ERROR)) {
            $this->get('flash')->error($this->get('session')->get(Security::LOGIN_ERROR));
        }
    }

}