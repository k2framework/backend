<?php

namespace K2\Backend\Service;

use K2\Kernel\Event\ExceptionEvent;
use K2\Di\Container\Container;
use K2\Security\Exception\UserNotAuthorizedException;

/**
 * Clase para capturar las excepciones del backend y crear las vistas
 * correspondientes.
 *
 * @author maguirre
 */
class Excepcion
{

    /**
     *
     * @var Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Método que captura las excepciones del Backend.
     * @param ExceptionEvent $event 
     */
    public function onException(ExceptionEvent $event)
    {
        if ($event->getException() instanceof UserNotAuthorizedException) {
            $url = $event->getRequest()->getRequestUrl();
            $response = $this->container->get('view')->render(array(
                'template' => 'K2/Backend:exception',
                'params' => compact('url'),
                    ));
            $event->setResponse($response);
        }
    }

}
