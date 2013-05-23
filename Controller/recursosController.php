<?php

namespace K2\Backend\Controller;

use K2\Kernel\App;
use K2\Backend\Model\Recursos;
use K2\Backend\Controller\Controller;

class recursosController extends Controller
{

    public function menu_lateral_action($active = 0)
    {
        $this->items = Recursos::createQuery()
                ->limit(8)
                ->order('id DESC')
                ->findAll('array');
        $this->active = $active;
        $this->column = 'recurso';

        $this->setView('@K2Backend/_partials/menu_lateral');
    }

    public function index_action($pagina = 1)
    {
        $this->recursos = Recursos::paginate($pagina, 10, 'array');
    }

    public function crear_action()
    {
        if ($this->getRequest()->isMethod('post')) {

            $recurso = new Recursos();

            App::get('mapper')->bindPublic($recurso, 'recurso');

            if ($recurso->save()) {
                App::get('flash')->success('El Recurso Ha Sido Agregado Exitosamente...!!!');
                return $this->getRouter()->toAction('editar/' . $recurso->id);
            } else {
                App::get('flash')->error($recurso->getErrors());
            }
        }
    }

    public function editar_action($id)
    {
        $this->titulo = 'Editar Recurso';

        $this->setView('@K2Backend/recursos/crear');

        $this->recurso = Recursos::findByID($id);

        if ($this->getRequest()->isMethod('post')) {

            App::get('mapper')->bindPublic($this->recurso, 'recurso');

            if ($this->recurso->save()) {
                App::get('flash')->success('El Recurso Ha Sido Actualizado Exitosamente...!!!');
                return $this->toAction('editar/' . $this->recurso->id);
            } else {
                App::get('flash')->error($this->recurso->getErrors());
            }
        }
    }

    public function eliminar_action($id = NULL)
    {
        if (is_numeric($id)) {
            //si es numero, queremos eliminar 1 solo.
            $recurso = Recursos::findByID($id);

            if ($recurso->delete()) {
                App::get('flash')->success("El recurso <b>{$recurso->recurso}</b> fué Eliminado...!!!");
            } else {
                App::get('flash')->warning("No se Pudo Eliminar el recurso <b>{$recurso->recurso}</b>...!!!");
            }
        } elseif (is_string($id)) {
            //si son varios ids concatenados por coma:    3,6,89,...
            $q = Recursos::createQuery();
            foreach (explode(',', $id) as $index => $e) {
                $q->whereOr("id = :id_$index")->bindValue("id_$index", $e);
            }

            if (Recursos::deleteAll($q)) {
                App::get('flash')->success("Los Recursos <b>{$id}</b> fueron Eliminados...!!!");
            } else {
                App::get('flash')->warning("No se Pudieron Eliminar los Recursos...!!!");
            }
        } elseif ($this->getRequest()->post('recursos_id', null)) {
            $this->ids = $this->getRequest()->post('recursos_id');
            return;
        }
        return $this->getRouter()->toAction();
    }

    public function activar_action($id)
    {
        $recurso = Recursos::findByID($id);

        $recurso->activo = true;

        if ($recurso->save()) {
            App::get('flash')->success("El recurso <b>{$recurso->recurso}</b> Esta ahora <b>Activo</b>...!!!");
        } else {
            App::get('flash')->warning("No se Pudo Activar el recurso <b>{$recurso->recurso}</b>...!!!");
        }
        return $this->getRouter()->toAction();
    }

    public function desactivar_action($id)
    {

        $recurso = Recursos::findByID($id);

        $recurso->activo = false;

        if ($recurso->save()) {
            App::get('flash')->success("El recurso <b>{$recurso->recurso}</b> Esta ahora <b>Inactivo</b>...!!!");
        } else {
            App::get('flash')->warning("No se Pudo Desactivar el recurso <b>{$recurso->recurso}</b>...!!!");
        }
        return $this->getRouter()->toAction();
    }

}
