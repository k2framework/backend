<?php

namespace K2\Backend\Form;

use KumbiaPHP\Form\Form;

/**
 * Description of Usuario
 *
 * @author maguirre
 */
class Usuario extends Form
{

    protected function init()
    {
        $this->add('login')
                ->setLabel('Nombre de Usuario (Login)')
                ->required();

        $this->add('clave', 'password')
                ->setLabel('Contrase&ntilde;a')
                ->required();

        $this->add('clave2', 'password')
                ->setLabel('Volver a escribir Contrase&ntilde;a')
                ->required();

        $this->add('nombres')
                ->setLabel('Nombre Completo')
                ->required();

        $this->add('email', 'email')
                ->setLabel('Correo Electronico')
                ->required();
    }

    public function prepareForCreate()
    {
        $this['clave'] = '';
        $this['clave2'] = '';
    }

    public function prepareForEdit()
    {
        unset($this['clave'], $this['clave2']);
    }

}
