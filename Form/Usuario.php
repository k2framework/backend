<?php

namespace K2\Backend\Form;

use K2\Form\Form;
use K2\Backend\Model\Roles;
use K2\Backend\Model\Usuarios;

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
                ->equalTo('clave2')
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

        $this->add('roles', 'select')
                ->setOptionsFromResultset(
                        , 'id', 'rol')
                ->setLabel('Roles de Usuario')
                ->attrs(array('multiple' => 'multiple'))
                ->required();
    }

    public static function create()
    {
        return new static(new Usuarios());
    }

    public static function edit(Usuarios $usr)
    {
        $form = new Form($usr);

        $form->add('roles', 'select')
                ->setOptionsFromResultset(Roles::findAllBy('activo', true)
                        , 'id', 'rol')
                ->setLabel('Roles de Usuario')
                ->attrs(array('multiple' => 'multiple'))
                ->setValue($usr->get('K2\\Backend\\Model\\Roles'))
                ->required();

        return $form;
    }

    public static function perfil(Usuarios $usr)
    {
        $form = new Form($usr);

        $form->setName('perfil');
        
        $form->add('nombres')
                ->setLabel('Nombre Completo')
                ->required();

        $form->add('email', 'email')
                ->setLabel('Correo Electronico')
                ->required();

        return $form;
    }

    public static function cambioClave(Usuarios $usr)
    {
        $form = new Form($usr);
        
        $form->setName('cambioClave');

        $form->add('clave_actual', 'password')
                ->setLabel('Contrase&ntilde;a Actual')
                ->required();

        $form->add('nueva_clave', 'password')
                ->setLabel('Nueva Contrase&ntilde;a')
                ->equalTo('clave2')
                ->setValue(NULL)
                ->required();

        $form->add('clave2', 'password')
                ->setLabel('Volver a escribir Contrase&ntilde;a')
                ->required();
        

        return $form;
    }

}
