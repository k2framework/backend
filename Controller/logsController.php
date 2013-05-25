<?php

namespace K2\Backend\Controller;

use K2\Backend\Model\Logs;
use K2\Backend\Model\Usuarios;
use K2\Backend\Controller\Controller;

class logsController extends Controller
{

    protected function getDataFilter()
    {
        $this->usuarios = Usuarios::createQuery()
                ->select('id, login')
                ->where('activo = 1')
                ->findAll(\PDO::FETCH_KEY_PAIR);

        $this->tabla = Logs::createQuery()
                ->select('DISTINCT tabla, tabla')
                ->findAll(\PDO::FETCH_KEY_PAIR);

        $this->tiposConsulta = Logs::createQuery()
                ->select('DISTINCT query_type, query_type')
                ->findAll(\PDO::FETCH_KEY_PAIR);
    }

    public function index_action($page = 1)
    {
        $this->getDataFilter();

        Logs::createQuery()
                ->columns('logs.*,usuarios.login')
                ->join('usuarios', 'usuarios.id = usuarios_id')
                ->order('logs.id DESC');

        $this->logs = Logs::paginate($page, 10, 'array');
    }

}
