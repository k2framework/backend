<?php

namespace K2\Backend\Controller;

use K2\Kernel\App;
use K2\Backend\Model\Menus;
use K2\Backend\Controller\Controller;

class menuController extends Controller
{

    public $visibilidad = array(
        Menus::BACKEND => 'Solo en El Backend',
        Menus::APP => 'Solo en La Aplicación, fuera del Backend',
        Menus::ALL => 'En cualquier parte del sistema',
    );

    public function menu_lateral_action($active = 0)
    {
        $this->items = Menus::createQuery()
                ->limit(8)
                ->order('id DESC')
                ->findAll();
        $this->active = $active;
        $this->column = 'nombre';

        $this->setView('@K2Backend/_partials/menu_lateral');
    }

    public function index_action($pagina = 1)
    {

        Menus::createQuery()
                ->select('menus.*, menuPadre.nombre as padre')
                ->leftJoin('menus as menuPadre', 'menuPadre.id = menus.menus_id');

        $this->menus = Menus::paginate($pagina);
    }

    public function crear_action()
    {
        $this->menus = Menus::findAll();

        if ($this->getRequest()->isMethod('post')) {

            $menu = new Menus();

            App::get('mapper')->bindPublic($menu, 'menu');

            if ($menu->save()) {
                App::get('flash')->success('El Menú Ha Sido Agregado Exitosamente...!!!');
                return $this->getRouter()->toAction('editar/' . $menu->id);
            } else {
                App::get('flash')->error($rol->getErrors());
            }
        }
    }

    public function editar_action($id)
    {
        $this->menus = Menus::findAll();

        $this->titulo = 'Editar Menu';

        $this->setView('@K2Backend/menu/crear');

        if (!$this->menu = Menus::findByID($id)) {
            return $this->renderNotFound("No existe el Menú con id = <b>$id</b>");
        }

        if ($this->getRequest()->isMethod('post')) {

            App::get('mapper')->bindPublic($this->menu, 'menu');

            if ($this->menu->save()) {
                App::get('flash')->success('El Menú Ha Sido Actualizado Exitosamente...!!!');
                return $this->toAction('editar/' . $this->menu->id);
            } else {
                App::get('flash')->error($this->menu->getErrors());
            }
        }
    }

    public function activar_action($id)
    {
        if (!$menu = Menus::findByPK((int) $id)) {
            return $this->renderNotFound("No existe el menu con id = <b>$id</b>");
        }

        $menu->activo = true;

        if ($menu->save()) {
            App::get('flash')->success("El menu <b>{$menu->nombre}</b> Esta ahora <b>Activo</b>...!!!");
        } else {
            App::get('flash')->warning("No se Pudo Activar el menu <b>{$menu->nombre}</b>...!!!");
        }
        return $this->getRouter()->toAction();
    }

    public function desactivar_action($id)
    {
        if (!$menu = Menus::findByPK((int) $id)) {
            return $this->renderNotFound("No existe el menu con id = <b>$id</b>");
        }

        $menu->activo = false;

        if ($menu->save()) {
            App::get('flash')->success("El menu <b>{$menu->nombre}</b> Esta ahora <b>Inactivo</b>...!!!");
        } else {
            App::get('flash')->warning("No se Pudo Desactivar el menu <b>{$menu->nombre}</b>...!!!");
        }
        return $this->getRouter()->toAction();
    }

    public function eliminar_action($id = NULL)
    {
        if (is_numeric($id)) {
            //si es numero, queremos eliminar 1 solo.
            if (!$menu = Menus::findByPK($id)) { //si no existe
                return $this->renderNotFound("No existe el Menú con id = <b>$id</b>");
            }

            if ($menu->delete()) {
                App::get('flash')->success("El Menú <b>{$menu->nombre}</b> fué Eliminado...!!!");
            } else {
                App::get('flash')->warning("No se Pudo Eliminar el Menú <b>{$menu->nombre}</b>...!!!");
            }
        } elseif (is_string($id)) {
            //si son varios ids concatenados por coma:    3,6,89,...
            $q = Menus::createQuery();
            foreach (explode(',', $id) as $index => $e) {
                $q->whereOr("id = :id_$index")->bindValue("id_$index", $e);
            }

            if (Menus::deleteAll($q)) {
                App::get('flash')->success("Los Menús <b>{$id}</b> fueron Eliminados...!!!");
            } else {
                App::get('flash')->warning("No se Pudieron Eliminar los Menús...!!!");
            }
        } elseif ($this->getRequest()->post('menu_id', null)) {
            $this->ids = $this->getRequest()->post('menu_id');
            return;
        }
        return $this->getRouter()->toAction();
    }

    public function items_action($entorno = Menus::APP)
    {
        $this->items = Menus::getItems($entorno);

        $this->security = \K2\Kernel\App::get('security');
    }

}
