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

    /**
     * Luego de ejecutar las acciones, se verifica si la petición es ajax
     * para no mostrar ni vista ni template.
     */
    protected function afterFilter()
    {
        if (App::getRequest()->isAjax()) {
            $this->setView(false);
        }
    }

    protected function beforeFilter()
    {
        if (!App::get('security')->isLogged()) {
            return App::get('firewall')->showLogin();
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