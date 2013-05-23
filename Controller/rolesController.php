<?php

namespace K2\Backend\Controller;

use K2\Kernel\App;
use K2\Backend\Model\Roles;
use K2\Backend\Controller\Controller;

class rolesController extends Controller
{

    public function menu_lateral_action($active = 0)
    {
        $this->items = Roles::createQuery()
                ->limit(8)
                ->order('id DESC')
                ->findAll('array');
        $this->active = $active;
        $this->column = 'rol';

        $this->setView('@K2Backend/_partials/menu_lateral');
    }

    public function index_action($pagina = 1)
    {
        $this->roles = Roles::paginate($pagina, 10, 'array');
    }

    public function crear_action()
    {
        if ($this->getRequest()->isMethod('post')) {

            $rol = new Roles();

            App::get('mapper')->bindPublic($rol, 'rol');

            if ($rol->save()) {
                App::get('flash')->success('El Rol Ha Sido Agregado Exitosamente...!!!');
                return $this->getRouter()->toAction('editar/' . $rol->id);
            } else {
                App::get('flash')->error($rol->getErrors());
            }
        }
    }

    public function editar_action($id)
    {
        $this->titulo = 'Editar Rol (Perfil)';

        $this->setView('@K2Backend/roles/crear');

        $this->rol = Roles::findByID($id);

        if ($this->getRequest()->isMethod('post')) {

            App::get('mapper')->bindPublic($this->rol, 'rol');

            if ($this->rol->save()) {
                App::get('flash')->success('El Rol Ha Sido Actualizado Exitosamente...!!!');
                return $this->toAction('editar/' . $this->rol->id);
            } else {
                App::get('flash')->error($this->rol->getErrors());
            }
        }
    }

    public function eliminar_action($id = NULL)
    {
        if (is_numeric($id)) {
            //si es numero, queremos eliminar 1 solo.
           $rol = Roles::findByID($id);

            if ($rol->delete()) {
                App::get('flash')->success("El rol <b>{$rol->rol}</b> fué Eliminado...!!!");
            } else {
                App::get('flash')->warning("No se Pudo Eliminar el Rol <b>{$rol->rol}</b>...!!!");
            }
        } elseif (is_string($id)) {
            //si son varios ids concatenados por coma:    3,6,89,...
            $q = Roles::createQuery();
            foreach (explode(',', $id) as $index => $e) {
                $q->whereOr("id = :id_$index")->bindValue("id_$index", $e);
            }

            if (Roles::deleteAll($q)) {
                App::get('flash')->success("Los Roles <b>{$id}</b> fueron Eliminados...!!!");
            } else {
                App::get('flash')->warning("No se Pudieron Eliminar los Roles...!!!");
            }
        } elseif ($this->getRequest()->request('roles_id', null)) {
            $this->ids = $this->getRequest()->request('roles_id');
            return;
        }
        return $this->getRouter()->toAction();
    }

    public function activar_action($id)
    {
        $rol = Roles::findByID($id);

        $rol->activo = true;

        if ($rol->save()) {
            App::get('flash')->success("El rol <b>{$rol->rol}</b> Esta ahora <b>Activo</b>...!!!");
        } else {
            App::get('flash')->warning("No se Pudo Activar el Rol <b>{$rol->rol}</b>...!!!");
        }
        return $this->getRouter()->toAction();
    }

    public function desactivar_action($id)
    {

        $rol = Roles::findByID($id);

        $rol->activo = false;

        if ($rol->save()) {
            App::get('flash')->success("El rol <b>{$rol->rol}</b> Esta ahora <b>Inactivo</b>...!!!");
        } else {
            App::get('flash')->warning("No se Pudo Desactivar el Rol <b>{$rol->rol}</b>...!!!");
        }
        return $this->getRouter()->toAction();
    }

}
