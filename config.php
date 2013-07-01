<?php

namespace K2\Backend;

use K2\Kernel\Event\K2Events as E;
use ActiveRecord\Event\Events as AREvents;

return array(
    'name' => 'K2Backend',
    'namespace' => __NAMESPACE__,
    'path' => __DIR__,
    'services' => array(
        'k2_backend_exception' => array(
            'callback' => function($c) {
                return new Service\Excepcion($c);
            },
            'tags' => array(
                array('name' => 'event.listener', 'event' => E::EXCEPTION, 'method' => 'onException'),
            ),
        ),
        'k2_backend_filter_resonse' => array(
            'callback' => function($c) {
                return new Service\FilterResponse();
            },
            'tags' => array(
                array('name' => 'event.listener', 'event' => E::RESPONSE, 'method' => 'onResponse'),
            ),
        ),
        'k2_backend_log' => array(
            'callback' => function($c) {
                return new Model\Logs();
            },
            'tags' => array(
                array('name' => 'event.listener', 'event' => AREvents::CREATE, 'method' => 'addLog'),
                array('name' => 'event.listener', 'event' => AREvents::UPDATE, 'method' => 'addLog'),
                array('name' => 'event.listener', 'event' => AREvents::DELETE, 'method' => 'addLog'),
            ),
        ),
    )
);


