<?php

namespace K2\Backend\Controller;

use K2\Kernel\App;
use K2\Kernel\Controller\Controller as Base;

/**
 * Description of IndexController
 *
 * @author manuel
 */
class Controller extends Base
{

    protected function beforeFilter()
    {
        if (!App::get('security')->isLogged()) {
            return App::get('firewall')->showLogin();
        }

        if (App::getRequest()->isAjax()) {
            $this->setView(false);
        }
    }

    protected function redirect($url = null)
    {
        if (!App::getRequest()->isAjax()) {
            return $this->getRouter()->redirect($url);
        }
    }

    protected function toAction($action = null)
    {
        if (!App::getRequest()->isAjax()) {
            return $this->getRouter()->toAction($action);
        }
    }

}