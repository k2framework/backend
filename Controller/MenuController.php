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
                    return $this->getRouter()->toAction('editar/' . $menu->id);
                } else {
                    $this->get('flash')->error($menu->getErrors());
                }
            }else{
                $this->get('flash')->error($form->getErrors());
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
                    $this->get('flash')->error($menu->getErrors());
                }
            }else{
                $this->get('flash')->error($form->getErrors());
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

            if (!Menus::findByPK($id)) {
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

            if (!Menus::findByPK($id)) {
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
        if (is_numeric($id)) {
            //si es numero, queremos eliminar 1 solo.
            if (!$menu = Menus::findByPK($id)) { //si no existe
                return $this->renderNotFound("No existe el Menú con id = <b>$id</b>");
            }

            if ($menu->delete()) {
                $this->get('flash')->success("El Menú <b>{$menu->nombre}</b> fué Eliminado...!!!");
            } else {
                $this->get('flash')->warning("No se Pudo Eliminar el Menú <b>{$menu->nombre}</b>...!!!");
            }
        } elseif (is_string($id)) {
            //si son varios ids concatenados por coma:    3,6,89,...
            $q = Menus::createQuery();
            foreach (explode(',', $id) as $index => $e) {
                $q->whereOr("id = :id_$index")->bindValue("id_$index", $e);
            }

            if (Menus::deleteAll()) {
                $this->get('flash')->success("Los Menús <b>{$id}</b> fueron Eliminados...!!!");
            } else {
                $this->get('flash')->warning("No se Pudieron Eliminar los Menús...!!!");
            }
        } elseif ($this->getRequest()->get('menu_id', NULL)) {
            $this->ids = $this->getRequest()->get('menu_id');
            return;
        }
        return $this->getRouter()->toAction();
    }

}
