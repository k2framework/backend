<?php

namespace K2\Backend\Controller;

use K2\Kernel\App;
use K2\Backend\Model\Roles;
use K2\Backend\Model\Recursos;
use K2\Backend\Model\RolesRecursos;
use K2\Backend\Controller\Controller;

/**
 * Description of IndexController
 *
 * @author manuel
 */
class privilegiosController extends Controller
{

    public function menu_lateral_action($active = 0)
    {
        $this->items = Roles::createQuery()
                ->limit(8)
                ->order('id DESC')
                ->findAll();
        $this->active = $active;
        $this->column = 'rol';

        $this->setView('@K2Backend/_partials/menu_lateral');
    }

    public function index_action()
    {
        Roles::createQuery()->order("id DESC");
        if (!$rol = Roles::find()) {
            App::get('flash')->info("No existe ningun rol en el sistema");
            return $this->getRouter()->redirect("@K2Backend/roles");
        } else {
            return $this->getRouter()->toAction('editar/' . $rol->id);
        }
    }

    public function editar_action($rol_id, $pagina = 1)
    {
        //verificamos la existencia del rol
        if (!$this->rol = Roles::findByID($rol_id)) {
            $this->renderNotFound("No existe el rol con id $rol_id");
        }

        RolesRecursos::createQuery()
                ->rightJoin('recursos as r', 'r.id = roles_recursos.recursos_id 
                    AND roles_id = :rol')
                ->columns("roles_recursos.id,roles_recursos.roles_id,
                    r.descripcion,r.recurso,r.id as recursos_id")
                ->group('r.id')
                ->bindValue('rol', $this->rol->id);

        $this->recursos = RolesRecursos::paginate($pagina, 10, Roles::FETCH_ARRAY);
        var_dump($this->recursos->items);
        die;
        if ($this->getRequest()->isMethod('post')) {
            $seleccionados = $this->getRequest()->get('recursos', array());
            //acá debemos actualizar los privilegios del rol.
            if (RolesRecursos::editar($this->rol, $this->recursos->items, $seleccionados)) {
                App::get('flash')->success("Los privilegios del Rol 
                        <b>{$this->rol->getName()}</b> fueron actualizados...!!!");
                //redireccionamos par que se vuelva a ejecutar la consulta.
                return $this->toAction("editar/{$rol_id}/{$pagina}");
            } else {
                App::get('flash')->error("No se pudieron Hacer los Cambios...!!!");
            }
        }
    }

}