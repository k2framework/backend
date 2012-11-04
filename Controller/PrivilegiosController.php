<?php

namespace K2\Backend\Controller;

use K2\Backend\Controller\Controller;
use K2\Backend\Model\Recursos;
use K2\Backend\Model\Roles;

/**
 * Description of IndexController
 *
 * @author manuel
 */
class PrivilegiosController extends Controller
{

    public function index()
    {
        
    }

    public function editar($rol_id, $pagina = 1)
    {
        //verificamos la existencia del rol
        if (!$this->rol = Roles::findByPK((int) $rol_id)) {
            $this->renderNotFound("No existe el rol con id $rol_id");
        }

        Recursos::createQuery()
                ->leftJoin('roles_recursos as rr', 'rr.recursos_id = recursos.id')
                ->columns("recursos.*, rr.roles_id as rol");
        $this->recursos = Recursos::paginate($pagina,1);
    }

}