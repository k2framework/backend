<?php

namespace K2\Backend\Form;

use K2\Form\Form;
use K2\Backend\Model\Roles;

/**
 * Description of Rol
 *
 * @author maguirre
 */
class Rol extends Form
{

    protected function init()
    {
        $this->add('rol')
                ->setLabel('Nombre del Rol')
                ->required();

        $this->add('plantilla')
                ->setLabel('Plantilla a usar');

        $this->add('activo', 'select')
                ->setLabel('Activo (Visible)')
                ->setOptions(array(
                    '1' => 'Si',
                    '0' => 'No',
                ))
                ->required();
    }

}
