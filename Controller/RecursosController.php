<?php

namespace K2\Backend\Controller;

use K2\Backend\Model\Recursos;
use K2\Backend\Form\Recurso as Form;
use K2\Backend\Controller\Controller;

class RecursosController extends Controller
{

    public function index($pagina = 1)
    {
        $this->recursos = Recursos::paginate($pagina);
    }

    public function crear()
    {
        $this->titulo = 'Crear Recurso';

        $form = new Form($recurso = new Recursos());

        if ($this->getRequest()->isMethod('post')) {
            if ($form->bindRequest($this->getRequest())->isValid()) {
                if ($recurso->save()) {
                    $this->get('flash')->success('El Recurso Ha Sido Agregado Exitosamente...!!!');
                    return $this->toAction('editar/' . $recurso->id);
                } else {
                    $form->setErrors($recurso->getErrors());
                }
            }
        }
        $this->form = $form;
    }

    public function editar($id)
    {
        $this->titulo = 'Editar Recurso';

        $this->setView('crear');

        if (!$recurso = Recursos::findByPK((int) $id)) {
            return $this->renderNotFound("No existe el Recurso con id = <b>$id</b>");
        }

        $form = new Form($recurso);

        if ($this->getRequest()->isMethod('post')) {
            if ($form->bindRequest($this->getRequest())->isValid()) {
                if ($recurso->save()) {
                    $this->get('flash')->success('El Recurso Ha Sido Actualizado Exitosamente...!!!');
                } else {
                    $form->setErrors($recurso->getErrors());
                }
            }
        }
        $this->form = $form;
        $this->recurso = $recurso;
    }

    public function eliminar($id = NULL)
    {
        if (is_numeric($id)) {
            //si es numero, queremos eliminar 1 solo.
            if (!$recurso = Recursos::findByPK($id)) { //si no existe
                return $this->renderNotFound("No existe el recurso con id = <b>$id</b>");
            }

            if ($recurso->delete()) {
                $this->get('flash')->success("El recurso <b>{$recurso->recurso}</b> fué Eliminado...!!!");
            } else {
                $this->get('flash')->warning("No se Pudo Eliminar el recurso <b>{$recurso->recurso}</b>...!!!");
            }
        } elseif (is_string($id)) {
            //si son varios ids concatenados por coma:    3,6,89,...
            $q = Recursos::createQuery();
            foreach (explode(',', $id) as $index => $e) {
                $q->whereOr("id = :id_$index")->bindValue("id_$index", $e);
            }

            if (Recursos::deleteAll()) {
                $this->get('flash')->success("Los Recursos <b>{$id}</b> fueron Eliminados...!!!");
            } else {
                $this->get('flash')->warning("No se Pudieron Eliminar los Recursos...!!!");
            }
        } elseif ($this->getRequest()->get('recursos_id', NULL)) {
            $this->ids = $this->getRequest()->get('recursos_id');
            return;
        }
        return $this->getRouter()->toAction();
    }

    public function activar($id)
    {
        if (!$recurso = Recursos::findByPK((int) $id)) {
            return $this->renderNotFound("No existe el recurso con id = <b>$id</b>");
        }

        $recurso->activo = true;

        if ($recurso->save()) {
            $this->get('flash')->success("El recurso <b>{$recurso->recurso}</b> Esta ahora <b>Activo</b>...!!!");
        } else {
            $this->get('flash')->warning("No se Pudo Activar el recurso <b>{$recurso->recurso}</b>...!!!");
        }
        return $this->getRouter()->toAction();
    }

    public function desactivar($id)
    {

        if (!$recurso = Recursos::findByPK((int) $id)) {
            return $this->renderNotFound("No existe el recurso con id = <b>$id</b>");
        }

        $recurso->activo = false;

        if ($recurso->save()) {
            $this->get('flash')->success("El recurso <b>{$recurso->recurso}</b> Esta ahora <b>Inactivo</b>...!!!");
        } else {
            $this->get('flash')->warning("No se Pudo Desactivar el recurso <b>{$recurso->recurso}</b>...!!!");
        }
        return $this->getRouter()->toAction();
    }

}
