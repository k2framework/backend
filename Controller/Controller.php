<?php

namespace K2\Backend\Controller;

use KumbiaPHP\Kernel\Controller\Controller as Base;

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
        if ($this->getRequest()->isAjax()) {
            $this->setView(null, 'K2/Backend:ajax');
        }
    }

    protected function beforeFilter()
    {
        if (!$this->get('security')->isLogged()) {
            return $this->get('firewall')->showLogin();
        }
        $this->setTemplate('K2/Backend:default');
    }

    protected function redirect($url = NULL)
    {
        if (!$this->getRequest()->isAjax()) {
            return $this->getRouter()->redirect($url);
        }
    }

    protected function toAction($action = NULL)
    {
        if (!$this->getRequest()->isAjax()) {
            return $this->getRouter()->toAction($action);
        }
    }

}