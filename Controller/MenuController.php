<?php

namespace K2\Backend\Controller;

use K2\Backend\Model\Menus;
use K2\Backend\Form\Menu as Form;
use K2\Backend\Controller\Controller;

class MenuController extends Controller
{

    public function index($pagina = 1)
    {
        
        Menus::createQuery()
                ->select('menus.*, menuPadre.nombre as padre')
                ->leftJoin('menus as menuPadre', 'menuPadre.id = menus.menus_id');
        
        $this->menus = Menus::paginate($pagina);
    }

    public function crear()
    {
        $this->titulo = 'Crear Menu';

        $form = new Form($menu = new Menus());

        if ($this->getRequest()->isMethod('post')) {
            if ($form->bindRequest($this->getRequest())->isValid()) {
                if ($menu->save()) {
                    $this->get('flash')->success('El Menú Ha Sido Agregado Exitosamente...!!!');
                    return $this->toAction('editar/' . $menu->id);
                } else {
                    $form->setErrors($menu->getErrors());
                }
            }
        }
        $this->form = $form;
    }

    public function editar($id)
    {
        $this->titulo = 'Editar Menu';

        $this->setView('crear');

        if (!$menu = Menus::findByPK((int) $id)) {
            return $this->renderNotFound("No existe el Menú con id = <b>$id</b>");
        }

        $form = new Form($menu);

        if ($this->getRequest()->isMethod('post')) {
            if ($form->bindRequest($this->getRequest())->isValid()) {
                if ($menu->save()) {
                    $this->get('flash')->success('El Menú Ha Sido Actualizado Exitosamente...!!!');
                } else {
                    $form->setErrors($menu->getErrors());
                }
            }
        }
        $this->form = $form;
        $this->menu = $menu;
    }

    public function activar($id)
    {
        try {
            $id = (int) $id;

            $menu = new Menus();

            if (!$menu->find_first($id)) {
                Flash::warning("No existe ningun menú con id '{$id}'");
            } elseif ($menu->activar()) {
                Flash::valid("El menu <b>{$menu->nombre}</b> Esta ahora <b>Activo</b>...!!!");
            } else {
                Flash::warning("No se Pudo Activar el menu <b>{$menu->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

    public function desactivar($id)
    {
        try {
            $id = (int) $id;

            $menu = new Menus();

            if (!$menu->find_first($id)) {
                Flash::warning("No existe ningun menú con id '{$id}'");
            } elseif ($menu->desactivar()) {
                Flash::valid("El menu <b>{$menu->nombre}</b> Esta ahora <b>Inactivo</b>...!!!");
            } else {
                Flash::warning("No se Pudo Desactivar el menu <b>{$menu->menu}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

    public function eliminar($id = NULL)
    {
        try {
            if (is_int($id)) {
                $menu = new Menus();

                if (!$menu->find_first($id)) {
                    Flash::warning("No existe ningun menú con id '{$id}'");
                } elseif ($menu->delete()) {
                    Flash::valid("El Menu <b>{$menu->nombre}</b> fué Eliminado...!!!");
                } else {
                    Flash::warning("No se Pudo Eliminar el Menu <b>{$menu->nombre}</b>...!!!");
                }
            } elseif (is_string($id)) {
                $menu = new Menus();
                if ($menu->delete_all("id IN ($id)")) {
                    Flash::valid("Los Menús <b>{$id}</b> fueron Eliminados...!!!");
                } else {
                    Flash::warning("No se Pudieron Eliminar los Menús...!!!");
                }
            } elseif (Input::hasPost('menu_id')) {
                $this->menus = Input::post('menu_id');
                return;
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

}
