<?php

namespace K2\Backend\Controller;

use K2\Backend\Model\Logs;
use K2\Backend\Model\Usuarios;
use K2\Backend\Controller\Controller;
use ActiveRecord\Event\Event;

class logsController extends Controller
{

    public $tiposConsulta = array(
        Event::INSERT => Event::INSERT,
        Event::UPDATE => Event::UPDATE,
        Event::DELETE => Event::DELETE,
    );

    public function index_action($page = 1)
    {
        $this->usuarios = Usuarios::findAll(array('activo' => true));

        Logs::createQuery()
                ->columns('logs.*,usuarios.login')
                ->join('usuarios', 'usuarios.id = usuarios_id')
                ->order('logs.id DESC');

        $this->logs = Logs::paginate($page, 10, 'array');
    }

}
