<?php

namespace K2\Backend;

use K2\Kernel\Module;
use K2\Kernel\Event\KumbiaEvents as E;

class K2BackendModule extends Module
{

    public function init()
    {
        $this->container->set('k2_backend_menu', function($c) {
                    return new Service\Menu($c['security']);
                })->set('k2_backend_exception', function($c) {
                    return new Service\Excepcion($c);
                })->set('k2_backend_filter_resonse', function($c) {
                    return new Service\FilterResponse();
                });
        $this->dispatcher->addListener(E::EXCEPTION, array('k2_backend_exception', 'onException'));
        $this->dispatcher->addListener(E::RESPONSE, array('k2_backend_filter_resonse', 'onResponse'));

        $this->container->setParameter('view', array(
            'flash' => 'K2/Backend:flashes'
        ));
    }

}