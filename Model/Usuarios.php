<?php

namespace K2\Backend\Model;

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

    public function auth(\KumbiaPHP\Security\Auth\User\UserInterface $user)
    {
        return TRUE; // crypt($user->getPassword()) === $this->getPassword();
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

            $roles = new RolesUsuarios();

            foreach ($this->roles as $rol_id) {
                if (!$roles->create(array('roles_id' => $rol_id, 'usuarios_id' => $this->id))) {
                    $this->rollback();
                    return false;
                }
            }

            $this->commit();
            return true;
            
        } else {
            return false;
        }
    }
    
    protected function beforeSave(){
        
    }

}