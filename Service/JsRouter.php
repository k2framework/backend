<?php

namespace K2\Backend\Service;

use KumbiaPHP\Kernel\Event\ResponseEvent;

/**
 * Description of JsRouter
 *
 * @author manuel
 */
class JsRouter
{

    public function onResponse(ResponseEvent $event)
    {
        if ($event->getRequest()->isAjax() &&
                ($event->getResponse()->headers->has('Location'))) {
            $url = $event->getResponse()->headers->get('Location');
            $script = "<script>window.location='$url';</script>";
            die($script);
            $event->getResponse()->setContent($script);
            $event->stopPropagation();
        }
    }

}