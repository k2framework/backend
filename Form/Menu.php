<?php

namespace K2\Backend\Form;

use KumbiaPHP\Form\Form;
use K2\Backend\Model\Menus;

/**
 * Description of Rol
 *
 * @author maguirre
 */
class Menu extends Form
{

    protected function init()
    {
        $this->add('menus_id', 'select')
                ->setLabel('Menú Padre')
                ->setOptionsFromResultset(Menus::findAll(), 'id', 'nombre')
                ->setDefault('- Seleccione -');

        $this->add('nombre')
                ->setLabel('Texto a Mostrar')
                ->required();

        $this->add('url')
                ->setLabel('URL del Menú')
                ->required();

        $this->add('posicion')
                ->setLabel('Relevancia del Elemento')
                ->setValue(100);

        $this->add('clases')
                ->setLabel('Clases CSS para el Item');

        $this->add('visible_en', 'radio')
                ->setLabel('Visible en')
                ->setOptions(array(
                    Menus::BACKEND => 'Solo en El Backend',
                    Menus::APP => 'Solo en La Aplicación, fuera del Backend',
                    Menus::ALL => 'En cualquier parte del sistema',
                ))->setSeparator('<br/>')
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
