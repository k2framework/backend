<?php

namespace K2\Backend\Service;

use KumbiaPHP\Kernel\Event\ExceptionEvent;
use KumbiaPHP\Di\Container\ContainerInterface;
use KumbiaPHP\Security\Exception\UserNotAuthorizedException;

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
     * @var ContainerInterface 
     */
    protected $container;

    public function __construct(ContainerInterface $container)
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
            $response = $this->container->get('view')
                    ->render('K2/Backend:exception', null, compact('url'));
            $event->setResponse($response);
        }
    }

}
