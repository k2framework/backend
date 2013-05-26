<?php

namespace K2\Backend;

use K2\Kernel\App;
use K2\Kernel\Event\K2Events as E;
use ActiveRecord\Event\Events as AREvents;

App::modules(array(
    include composerPath('k2/breadcrumb', 'K2/Breadcrumb'),
));

return array(
    'name' => 'K2Backend',
    'namespace' => __NAMESPACE__,
    'path' => __DIR__,
    'services' => array(
        'k2_backend_exception' => function($c) {
            return new Service\Excepcion($c);
        },
        'k2_backend_filter_resonse' => function($c) {
            return new Service\FilterResponse();
        },
        'k2_backend_log' => function($c) {
            return new Model\Logs();
        },
    ),
    'listeners' => array(
        E::EXCEPTION => array(
            array('k2_backend_exception', 'onException'),
        ),
        E::RESPONSE => array(
            array('k2_backend_filter_resonse', 'onResponse')
        ),
        AREvents::CREATE => array(
            array('k2_backend_log', 'addLog')
        ),
        AREvents::UPDATE => array(
            array('k2_backend_log', 'addLog')
        ),
        AREvents::DELETE => array(
            array('k2_backend_log', 'addLog')
        ),
    ),
);


