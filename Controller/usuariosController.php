<?php

namespace K2\Backend\Controller;

use K2\Kernel\App;
use K2\Backend\Model\Roles;
use K2\Backend\Model\Usuarios;
use K2\Backend\Controller\Controller;

class usuariosController extends Controller
{

    public function menu_lateral_action($active = 0)
    {
        $this->items = Usuarios::createQuery()
                ->limit(8)
                ->order('id DESC')
                ->findAll();
        $this->active = $active;
        $this->column = 'login';

        $this->setView('@K2Backend/_partials/menu_lateral');
    }

    public function index_action($pagina = 1)
    {
        $this->usuarios = Usuarios::paginate($pagina);
    }

    /**
     * Cambio de los datos personales de usuario.
     * 
     */
    public function perfil_action()
    {
        $this->usuario = Usuarios::findByPK(App::get('security')->getToken('id'));

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
        $this->roles = Roles::findAllBy(array('activo' => true));

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
        if (!$this->usuario = Usuarios::findByPK((int) $id)) {
            $this->renderNotFound("No existe ningun usuario con id '{$id}'");
        }

        $this->roles = Roles::findAllBy(array('activo' => true));

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
        if (!$usuario = Usuarios::findByPK((int) $id)) {
            $this->renderNotFound("No existe ningun usuario con id '{$id}'");
        }

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
        if (!$usuario = Usuarios::findByPK((int) $id)) {
            $this->renderNotFound("No existe ningun usuario con id '{$id}'");
        }

        $usuario->activo = false;

        if ($usuario->save()) {
            App::get('flash')->success("La Cuenta del Usuario {$usuario->login} ({$usuario->nombres}) fué desactivada...!!!");
        } else {
            App::get('flash')->warning('No se Pudo Desactivar la cuenta del Usuario...!!!');
        }
        return $this->getRouter()->toAction();
    }

}
