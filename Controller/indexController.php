<?php

namespace K2\Backend\Controller;

use KumbiaPHP\Kernel\Controller\Controller;

/**
 * Description of IndexController
 *
 * @author manuel
 */
class indexController extends Controller
{

    protected function beforeFilter()
    {
        if ($this->getRequest()->isAjax()) {
            $this->setTemplate(NULL);
        }else{
            $this->setTemplate('K2/Backend:login');            
        }
        $this->limitParams = false;
    }

    public function index_action()
    {
        return $this->getRouter()->forward('K2/Backend:usuarios/index');
    }

    public function login_action()
    {
        $this->setView(null);
    }

}