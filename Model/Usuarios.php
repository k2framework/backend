<?php

namespace K2\Backend\Model;

use K2\Backend\Model\RolesUsuarios;
use K2\ActiveRecord\ActiveRecord;
use K2\Security\Auth\User\UserInterface;
use K2\ActiveRecord\Validation\ValidationBuilder;

/**
 * Description of Usuarios
 *
 * @author maguirre
 */
class Usuarios extends ActiveRecord implements UserInterface
{

    const HASH = 'K2_BACKEND';

    protected function createRelations()
    {
        $this->hasAndBelongsToMany('K2\\Backend\\Model\\Roles'
                , 'K2\\Backend\\Model\\RolesUsuarios');
    }

    protected function validations(ValidationBuilder $builder)
    {
        $builder->notNull('login', array(
            'message' => "Escribe tu login por favor"
        ))->unique('login', array(
            'message' => "El <b>login</b> ya está siendo Utilizado"
        ));
        return $builder;
    }

    public function auth(UserInterface $user)
    {
        return $this->createHash($user->getPassword()) === $this->getPassword()
                && $this->activo == true;
    }

    public function getPassword()
    {
        return $this->clave;
    }

    public function getRoles()
    {
        return $this->get('K2\\Backend\\Model\\Roles');
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function guardar()
    {
        $this->begin();

        if ($this->save()) {
            $this->commit();
            return true;
        }
        //$this->addError('TODO', 'No se Pudieron Guardar los Datos...!!!');
        $this->rollback();
        return false;
    }

    protected function beforeCreate()
    {
        if (!isset($this->roles) || !is_array($this->roles)) {
            return false;
        }
    }

    protected function beforeSave()
    {
        //si se está editando la clave
        if (isset($this->clave_actual)) {
            if ($this->createHash($this->clave_actual) !== $this->clave) {
                $this->addError('clave', 'La clave Actual no es Correcta');
                return false;
            }
            $this->clave = $this->nueva_clave;
        }
        //verificación y guardado de clave.
        if (isset($this->clave, $this->clave2)) {
            if ($this->clave !== $this->clave2) {
                $this->addError('clave', 'Las claves no Coinciden');
                return false;
            } else {
                $this->clave = $this->createHash($this->clave);
            }
        }
    }

    protected function afterSave()
    {
        //verificación y guardado de roles
        if (isset($this->roles) && is_array($this->roles)) {

            $roles = new RolesUsuarios();

            $q = RolesUsuarios::createQuery()
                    ->where('usuarios_id = :id')
                    ->bindValue('id', $this->id);

            RolesUsuarios::deleteAll($q);

            foreach ($this->roles as $rol_id) {
                if (!$roles->create(array('roles_id' => $rol_id, 'usuarios_id' => $this->id))) {
                    $this->addError('TODO', 'No se Pudieron Guardar los Datos...!!!');
                    return false;
                }
            }
        }
    }

    protected function createHash($value)
    {
        return crypt($value, self::HASH);
    }

}