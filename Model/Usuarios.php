<?php

namespace K2\Backend\Model;

use K2\Backend\Model\RolesUsuarios;
use KumbiaPHP\ActiveRecord\ActiveRecord;
use KumbiaPHP\Security\Auth\User\UserInterface;
use KumbiaPHP\ActiveRecord\Validation\ValidationBuilder;

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
            'message' => "Escribe tu login por favor :-)"
        ));
        return $builder;
    }

    public function auth(UserInterface $user)
    {
        return TRUE; //$this->createHash($user->getPassword()) === $this->getPassword();
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

    public function crear()
    {
        if (isset($this->roles) && is_array($this->roles)) {

            $this->begin();

            if (!$this->save()) {
                $this->rollback();
                return false;
            }

            $this->commit();
            return true;
        } else {
            return false;
        }
    }

    protected function beforeSave()
    {
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

            RolesUsuarios::createQuery()
                    ->where('usuarios_id = :id')
                    ->bindValue('id', $this->id);

            RolesUsuarios::deleteAll();

            foreach ($this->roles as $rol_id) {
                if (!$roles->create(array('roles_id' => $rol_id, 'usuarios_id' => $this->id))) {
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