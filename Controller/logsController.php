<?php

namespace K2\Backend\Controller;

use K2\Backend\Model\Logs;
use K2\Backend\Controller\Controller;

class logsController extends Controller
{

    public function index_action($page = 1)
    {
        Logs::createQuery()
                ->columns('logs.*,usuarios.login')
                ->join('usuarios', 'usuarios.id = usuarios_id')
                ->order('logs.id DESC');

        $this->logs = Logs::paginate($page, 10, 'array');
    }

}
