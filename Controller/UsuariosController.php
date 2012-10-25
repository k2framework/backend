<?php

namespace K2\Backend\Controller;

use K2\Backend\Form\Usuario as Form;
use K2\Backend\Model\Usuarios;
use KumbiaPHP\Kernel\Controller\Controller;

class UsuariosController extends Controller
{

    /**
     * Luego de ejecutar las acciones, se verifica si la petición es ajax
     * para no mostrar ni vista ni template.
     */
    protected function afterFilter()
    {
        if ($this->getRequest()->isAjax()) {
            $this->setView(null, null);
        }
    }

    protected function beforeFilter()
    {
        $this->setTemplate('K2/Backend:default');
    }

    public function index($pagina = 1)
    {
        $usr = new Usuarios();
        $this->usuarios = $usr->paginate($pagina);
    }

    /**
     * Cambio de los datos personales de usuario.
     * 
     */
//    public function perfil()
//    {
//        try {
//            $usr = new Usuarios();
//            $this->usuario1 = $usr->find_first(Auth::get('id'));
//            if (Input::hasPost('usuario1')) {
//                if ($usr->update(Input::post('usuario1'))) {
//                    Flash::valid('Datos Actualizados Correctamente');
//                    $this->usuario1 = $usr;
//                }
//            } else if (Input::hasPost('usuario2')) {
//                if ($usr->cambiarClave(Input::post('usuario2'))) {
//                    Flash::valid('Clave Actualizada Correctamente');
//                    $this->usuario1 = $usr;
//                }
//            }
//        } catch (KumbiaException $e) {
//            View::excepcion($e);
//        }
//    }

    /**
     * Crea un usuario desde el backend.
     */
    public function crear()
    {
        $this->form = new Form(new Usuarios());

        if ($this->getRequest()->isMethod('POST')) {
            if ($this->form->bindRequest($this->getRequest())->isValid()) {
                if ($this->form->getData()->save()) {
                    $this->get('flash')->success('El Usuario Ha Sido Creado Exitosamente...!!!');
                    if (!$this->getRequest()->isAjax()) {
                        return $this->getRouter()->toAction();
                    }
                } else {
                    $this->get('flash')->warning('No se Pudieron Guardar los Datos...!!!');
                }
            }
        }
    }

    /**
     * Edita los datos de un usuario desde el backend.
     * @param  int $id id del usuario a editar
     */
    public function editar($id)
    {
//        try {
//
//            $id = (int) $id;
//
//            $usr = new Usuarios();
//
//            $this->usuario = $usr->find_first($id);
//
//            if ($this->usuario) {// verificamos la existencia del usuario
//                //obtenemos los roles que tiene el usuario
//                //para mostrar los checks seleccionados para estos roles.
//                $this->rolesUser = $usr->rolesUserIds();
//
//                //obtenemos los roles con los que se crearán los checks.
//                $this->roles = Load::model('admin/roles')->find_all_by_activo(1);
//
//                if (Input::hasPost('usuario')) {
//
//                    //guarda los datos del usuario, y le asigna los roles 
//                    //seleccionados en el formulario.
//                    if ($usr->guardar(Input::post('usuario'), Input::post('rolesUser'))) {
//                        Flash::valid('El Usuario Ha Sido Actualizado Exitosamente...!!!');
//                        if (!Input::isAjax()) {
//                            return Router::redirect();
//                        }
//                    } else {
//                        Flash::warning('No se Pudieron Guardar los Datos...!!!');
//                    }
//                }
//            } else {
//                Flash::warning("No existe ningun usuario con id '{$id}'");
//                if (!Input::isAjax()) {
//                    return Router::redirect();
//                }
//            }
//        } catch (KumbiaException $e) {
//            View::excepcion($e);
//        }
    }

    /**
     * Activa un usuario desde el backend
     * @param  int $id id del usuario a activar
     */
    public function activar($id)
    {
//        try {
//            $id = (int) $id;
//            $usuario = new Usuarios();
//            if (!$usuario->find_first($id)) { //si no existe el usuario
//                Flash::warning("No existe ningun usuario con id '{$id}'");
//            } else if ($usuario->activar()) {
//                Flash::valid("La Cuenta del Usuario {$usuario->login} ({$usuario->nombres}) fué activada...!!!");
//            } else {
//                Flash::warning('No se Pudo Activar la cuenta del Usuario...!!!');
//            }
//        } catch (KumbiaException $e) {
//            View::excepcion($e);
//        }
//        return Router::toAction('');
    }

    /**
     * Desactiva un usuario desde el backend
     * @param  int $id id del usuario a desactivar
     */
    public function desactivar($id)
    {
//        try {
//            $id = (int) $id;
//            $usuario = new Usuarios();
//            if (!$usuario->find_first($id)) { //si no existe el usuario
//                Flash::warning("No existe ningun usuario con id '{$id}'");
//            } else if ($usuario->desactivar()) {
//                Flash::valid("La Cuenta del Usuario {$usuario->login} ({$usuario->nombres}) fué desactivada...!!!");
//            } else {
//                Flash::warning('No se Pudo Desactivar la cuenta del Usuario...!!!');
//            }
//        } catch (KumbiaException $e) {
//            View::excepcion($e);
//        }
//        return Router::toAction('');
    }

}
