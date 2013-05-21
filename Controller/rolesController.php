<?php

namespace K2\Backend\Controller;

use K2\Kernel\App;
use K2\Backend\Model\Roles;
use K2\Backend\Controller\Controller;

class rolesController extends Controller
{

    public function index_action($pagina = 1)
    {
        $this->roles = Roles::paginate($pagina);
    }

    public function crear_action()
    {
        $this->titulo = 'Crear Rol (Perfil)';

        $form = new Form($rol = new Roles());

        if ($this->getRequest()->isMethod('post')) {
            if ($form->bindRequest($this->getRequest())->isValid()) {
                if ($rol->save()) {
                    App::get('flash')->success('El Rol Ha Sido Agregado Exitosamente...!!!');
                    return $this->getRouter()->toAction('editar/' . $rol->id);
                } else {
                    App::get('flash')->error($rol->getErrors());
                }
            } else {
                App::get('flash')->error($form->getErrors());
            }
        }
        $this->form = $form;
    }

    public function editar_action($id)
    {
        $this->titulo = 'Editar Rol (Perfil)';

        $this->setView('crear');

        if (!$rol = Roles::findByPK((int) $id)) {
            return $this->renderNotFound("No existe el Rol con id = <b>$id</b>");
        }

        $form = new Form($rol);

        if ($this->getRequest()->isMethod('post')) {
            if ($form->bindRequest($this->getRequest())->isValid()) {
                if ($rol->save()) {
                    App::get('flash')->success('El Rol Ha Sido Actualizado Exitosamente...!!!');
                } else {
                    App::get('flash')->error($rol->getErrors());
                }
            } else {
                App::get('flash')->error($form->getErrors());
            }
        }
        $this->form = $form;
        $this->rol = $rol;
    }

    public function eliminar_action($id = NULL)
    {
        if (is_numeric($id)) {
            //si es numero, queremos eliminar 1 solo.
            if (!$rol = Roles::findByID($id)) { //si no existe
                return $this->renderNotFound("No existe el Rol con id = <b>$id</b>");
            }

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

            if (Roles::deleteAll()) {
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
        if (!$rol = Roles::findByPK((int) $id)) {
            return $this->renderNotFound("No existe el Rol con id = <b>$id</b>");
        }

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

        if (!$rol = Roles::findByPK((int) $id)) {
            return $this->renderNotFound("No existe el Rol con id = <b>$id</b>");
        }

        $rol->activo = false;

        if ($rol->save()) {
            App::get('flash')->success("El rol <b>{$rol->rol}</b> Esta ahora <b>Inactivo</b>...!!!");
        } else {
            App::get('flash')->warning("No se Pudo Desactivar el Rol <b>{$rol->rol}</b>...!!!");
        }
        return $this->getRouter()->toAction();
    }

}
