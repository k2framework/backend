<?php

namespace K2\Backend\Service;

use KumbiaPHP\Flash\Flash as Base;
use KumbiaPHP\Kernel\Event\ResponseEvent;

/**
 * Clase que permite el envio de mensajes flash desde un controlador,
 * para luego ser leido en las vistas.
 * 
 * Cada vez que leemos los mensajes que han sido previamente guardados,
 * estos son borrados de la sesión, para que solo nos aparescan una vez.
 *
 * @author manuel
 */
class Flash extends Base
{

    public function __toString()
    {
        $code = '<div class="messages-flash">' . PHP_EOL;
        foreach ((array) $this->getAll() as $type => $message) {
            $code.= "<div class=\"alert alert-$type\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
            $message</div>" . PHP_EOL;
        }
        $code .= '</div>' . PHP_EOL;
        return $code;
    }

    public function onResponse(ResponseEvent $event)
    {
        if ('' === $event->getResponse()->getContent()) {
            $event->getResponse()->setContent((string) $this);
        }
    }

}