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

}