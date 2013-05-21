<?php

namespace K2\Backend;

use K2\Kernel\Event\K2Events as E;

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
    ),
    'listeners' => array(
        E::EXCEPTION => array(
            array('k2_backend_exception', 'onException'),
        ),
        E::RESPONSE => array(
            array('k2_backend_filter_resonse', 'onResponse')
        ),
    ),
);


