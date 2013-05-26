<?php

namespace K2\Backend\Controller;

use K2\Backend\Model\Logs;
use K2\Backend\Model\Usuarios;
use K2\Backend\Controller\Controller;

class logsController extends Controller
{

    protected function afterFilter()
    {
        
    }

    public function filtro($filtro = null)
    {
        $this->usuarios = Usuarios::createQuery()
                ->select('login, login')
                ->where('activo = 1')
                ->findAll(\PDO::FETCH_KEY_PAIR);

        $this->tabla = Logs::createQuery()
                ->select('DISTINCT tabla, tabla')
                ->findAll(\PDO::FETCH_KEY_PAIR);

        $this->tiposConsulta = Logs::createQuery()
                ->select('DISTINCT query_type, query_type')
                ->findAll(\PDO::FETCH_KEY_PAIR);

        $this->filtro = $filtro;
    }

    public function index_action($page = 1)
    {
        Logs::createQuery()
                ->columns('logs.*,usuarios.login')
                ->join('usuarios', 'usuarios.id = usuarios_id')
                ->order('logs.id DESC');

        $this->logs = Logs::paginate($page, 10, 'array');
    }

    public function filtrar_action($page = 1)
    {
        $request = $this->getRequest();
        if ($request->isAjax() && $request->isMethod('POST')) {

            $filtro = array_filter($request->post('filtro'));

            Logs::createQuery()
                    ->columns('logs.*,usuarios.login')
                    ->join('usuarios', 'usuarios.id = usuarios_id')
                    ->where($filtro)
                    ->order('logs.id DESC');

            $this->logs = Logs::paginate($page, 10, 'array');

            $this->setView("@K2Backend/logs/index.tabla");
        } else {
            return $this->index_action($page);
        }
    }

}
