<?php

namespace K2\Backend\Controller;

use K2\Backend\Model\Usuarios;
use K2\Backend\Form\Usuario as Form;
use K2\Backend\Controller\Controller;

class UsuariosController extends Controller
{

    public function index($pagina = 1)
    {
        $this->usuarios = Usuarios::paginate($pagina);
    }

    /**
     * Cambio de los datos personales de usuario.
     * 
     */
    public function perfil()
    {
        $this->usuario = Usuarios::findByPK($this->get('security')->getToken('id'));

        $this->form1 = Form::perfil($this->usuario);

        $this->form2 = Form::cambioClave($this->usuario);

        if ($this->getRequest()->isMethod('post')) {
            if ($this->getRequest()->get('perfil')) {
                $form = $this->form1;
            } elseif ($this->getRequest()->get('cambioClave')) {
                $form = $this->form2;
            }
            if ($form->bindRequest($this->getRequest())->isValid()) {
                if ($this->usuario->guardar()) {
                    $this->get('flash')->success('Los datos fueron guardados correctamente...!!!');
                } else {
                    $this->get('flash')->error($this->usuario->getErrors());
                }
            } else {
                $this->get('flash')->error($form->getErrors());
            }
        }
        $this->form2->setData(array());
    }

    /**
     * Crea un usuario desde el backend.
     */
    public function crear()
    {
        $this->form = Form::create();

        if ($this->getRequest()->isMethod('POST')) {
            if ($this->form->bindRequest($this->getRequest())->isValid()) {
                $usuario = $this->form->getData();
                if ($usuario->guardar()) {
                    $this->get('flash')->success('El Usuario Ha Sido Creado Exitosamente...!!!');
                    return $this->getRouter()->toAction('editar/' . $usuario->id);
                } else {
                    $this->get('flash')->error($this->usuario->getErrors());
                }
            } else {
                $this->get('flash')->error($form->getErrors());
            }
        }
    }

    /**
     * Edita los datos de un usuario desde el backend.
     * @param  int $id id del usuario a editar
     */
    public function editar($id)
    {
        if (!$this->usuario = Usuarios::findByPK((int) $id)) {
            $this->renderNotFound("No existe ningun usuario con id '{$id}'");
        }

        $this->form = Form::edit($this->usuario);

        if ($this->getRequest()->isMethod('POST')) {
            if ($this->form->bindRequest($this->getRequest())->isValid()) {
                if ($this->usuario->guardar()) {
                    $this->get('flash')->success('El Usuario Ha Sido Actualizado Exitosamente...!!!');
                } else {
                    $this->get('flash')->error($this->usuario->getErrors());
                }
            } else {
                $this->get('flash')->error($form->getErrors());
            }
        }
    }

    /**
     * Activa un usuario desde el backend
     * @param  int $id id del usuario a activar
     */
    public function activar($id)
    {
        if (!$usuario = Usuarios::findByPK((int) $id)) {
            $this->renderNotFound("No existe ningun usuario con id '{$id}'");
        }

        $usuario->activo = true;

        if ($usuario->save()) {
            $this->get('flash')->success("La Cuenta del Usuario {$usuario->login} ({$usuario->nombres}) fué activada...!!!");
        } else {
            $this->get('flash')->warning('No se Pudo Activar la cuenta del Usuario...!!!');
        }
        return $this->getRouter()->toAction();
    }

    /**
     * Desactiva un usuario desde el backend
     * @param  int $id id del usuario a desactivar
     */
    public function desactivar($id)
    {
        if (!$usuario = Usuarios::findByPK((int) $id)) {
            $this->renderNotFound("No existe ningun usuario con id '{$id}'");
        }

        $usuario->activo = false;

        if ($usuario->save()) {
            $this->get('flash')->success("La Cuenta del Usuario {$usuario->login} ({$usuario->nombres}) fué desactivada...!!!");
        } else {
            $this->get('flash')->warning('No se Pudo Desactivar la cuenta del Usuario...!!!');
        }
        return $this->getRouter()->toAction();
    }

}
