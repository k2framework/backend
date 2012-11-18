<?php

namespace K2\Backend\Controller;

use K2\Backend\Model\Roles;
use K2\Backend\Model\Recursos;
use K2\Backend\Model\RolesRecursos;
use K2\Backend\Controller\Controller;

/**
 * Description of IndexController
 *
 * @author manuel
 */
class PrivilegiosController extends Controller
{

    public function index()
    {
        Roles::createQuery()->order("id DESC");
        if (!$rol = Roles::first()) {
            $this->setView(null);
            $this->get('flash')->info("No existe ningun rol en el sistema");
        }
        return $this->getRouter()->toAction('editar/' . $rol->id);
    }

    public function editar($rol_id, $pagina = 1)
    {
        //verificamos la existencia del rol
        if (!$this->rol = Roles::findByPK((int) $rol_id)) {
            $this->renderNotFound("No existe el rol con id $rol_id");
        }

        RolesRecursos::createQuery()
                ->rightJoin('recursos as r', 'r.id = roles_recursos.recursos_id 
                    AND roles_id = :rol')
                ->columns("roles_recursos.id,roles_recursos.roles_id,
                    r.descripcion,r.recurso,r.id as recursos_id")
                ->group('r.id')
                ->bindValue('rol', $this->rol->id);

        $this->recursos = RolesRecursos::paginate($pagina);
        $this->get("k2_debug")->dump("data", $this->recursos);

        if ($this->getRequest()->isMethod('post')) {
            $seleccionados = $this->getRequest()->get('recursos');
            //acá debemos actualizar los privilegios del rol.
            if (RolesRecursos::editar($this->rol, $this->recursos->items, $seleccionados)) {
                $this->get('flash')->success("Los privilegios del Rol 
                        <b>{$this->rol->getName()}</b> fueron actualizados...!!!");
                //redireccionamos par que se vuelva a ejecutar la consulta.
                return $this->toAction("editar/{$rol_id}/{$pagina}");
            } else {
                $this->get('flash')->error("No se pudieron Hacer los Cambios...!!!");
            }
        }
    }

}