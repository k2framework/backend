<?php

namespace K2\Backend\Controller;

use K2\Kernel\App;
use K2\Backend\Model\Roles;
use K2\Backend\Model\Usuarios;
use K2\Backend\Controller\Controller;

class usuariosController extends Controller
{

    public function menu_lateral($active = 0)
    {
        $this->items = Usuarios::createQuery()
                ->limit(8)
                ->order('id DESC')
                ->findAll('array');
        $this->active = $active;
        $this->column = 'login';

        $this->setView('@K2Backend/_partials/menu_lateral');
    }

    public function index_action($pagina = 1)
    {
        $this->usuarios = Usuarios::paginate($pagina, 10, 'array');
    }

    /**
     * Cambio de los datos personales de usuario.
     * 
     */
    public function perfil_action()
    {
        $this->usuario = Usuarios::findByID(App::get('security')->getToken('id'));

        if ($this->getRequest()->isMethod('post')) {
            if ($this->getRequest()->request('perfil')) {
                App::get('mapper')->bindPublic($this->usuario, 'perfil');
            } elseif ($this->getRequest()->request('clave')) {
                App::get('mapper')->bindPublic($this->usuario, 'clave');
            }

            if ($this->usuario->guardar()) {
                App::get('flash')->success('Los datos fueron guardados correctamente...!!!');
            } else {
                App::get('flash')->error($this->usuario->getErrors());
            }
        }

        $this->perfil = $this->clave = $this->usuario;
    }

    /**
     * Crea un usuario desde el backend.
     */
    public function crear_action()
    {
        $this->roles = Roles::createQuery()
                ->select('id, rol')
                ->where(array('activo' => true))
                ->findAll(\PDO::FETCH_KEY_PAIR);

        if ($this->getRequest()->isMethod('POST')) {

            $user = new Usuarios();

            App::get('mapper')->bindPublic($user, 'usuario');

            if ($user->guardar()) {
                App::get('flash')->success('El Usuario Ha Sido Creado Exitosamente...!!!');
                return $this->getRouter()->toAction('editar/' . $user->id);
            } else {
                App::get('flash')->error($user->getErrors());
            }
        }
    }

    /**
     * Edita los datos de un usuario desde el backend.
     * @param  int $id id del usuario a editar
     */
    public function editar_action($id)
    {
        $this->usuario = Usuarios::findByID($id);

        $this->roles = Roles::createQuery()
                ->select('id, rol')
                ->where(array('activo' => true))
                ->findAll(\PDO::FETCH_KEY_PAIR);

        if ($this->getRequest()->isMethod('POST')) {

            App::get('mapper')->bindPublic($this->usuario, 'usuario');

            if ($this->usuario->guardar()) {
                App::get('flash')->success('El Usuario Ha Sido Actualizado Exitosamente...!!!');
                return $this->getRouter()->toAction('editar/' . $this->usuario->id);
            } else {
                App::get('flash')->error($this->usuario->getErrors());
            }
        }
    }

    /**
     * Activa un usuario desde el backend
     * @param  int $id id del usuario a activar
     */
    public function activar_action($id)
    {
        $usuario = Usuarios::findByID($id);

        $usuario->activo = true;

        if ($usuario->save()) {
            App::get('flash')->success("La Cuenta del Usuario {$usuario->login} ({$usuario->nombres}) fué activada...!!!");
        } else {
            App::get('flash')->warning('No se Pudo Activar la cuenta del Usuario...!!!');
        }
        return $this->getRouter()->toAction();
    }

    /**
     * Desactiva un usuario desde el backend
     * @param  int $id id del usuario a desactivar
     */
    public function desactivar_action($id)
    {
        $usuario = Usuarios::findByID($id);

        $usuario->activo = 0;

        if ($usuario->save()) {
            App::get('flash')->success("La Cuenta del Usuario {$usuario->login} ({$usuario->nombres}) fué desactivada...!!!");
        } else {
            App::get('flash')->warning('No se Pudo Desactivar la cuenta del Usuario...!!!');
        }
        return $this->getRouter()->toAction();
    }

}
