<?php

namespace K2\Backend\Service;

use K2\View\View;
use K2\Kernel\Event\ResponseEvent;

/**
 * La clase Ejecuta funcionalidades en el evento kumbia.response
 *
 * @author manuel
 */
class FilterResponse
{

    public function onResponse(ResponseEvent $event)
    {
        if ($event->getRequest()->isAjax() &&
                ($event->getResponse()->headers->has('Location'))) {
            //cuando la petición sea ajax y estemos redirigiendo, lo hacemos por javascript.
            $url = $event->getResponse()->headers->get('Location');
            $script = "<script>window.location='$url';</script>";
            die($script);
            $event->getResponse()->setContent($script);
            $event->stopPropagation();
        } elseif (null === $event->getResponse()->getContent()) {
            $content = \K2\Kernel\App::get('twig')->render('@K2Backend/_partials/flashes.twig');
            //si no devolvimos ninguna data en la respuesta, cargamos los mensajes flash
            $event->getResponse()->setContent($content); //mostramos los mensajes flash
        }
    }

}