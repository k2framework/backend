<?php

namespace K2\Backend\Form;

use K2\Form\Form;
use K2\Backend\Model\Recursos;

/**
 * Description of Rol
 *
 * @author maguirre
 */
class Recurso extends Form
{

    protected function init()
    {
        $this->add('recurso')
                ->setLabel('Ruta')
                ->required();

        $this->add('descripcion','textarea')
                ->setLabel('Descripción')
                ->required();

        $this->add('activo', 'select')
                ->setLabel('Activo (Visible)')
                ->setOptions(array(
                    '1' => 'Si',
                    '0' => 'No',
                ))
                ->required();
    }

}
