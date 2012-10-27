<?php

namespace K2\Backend\Model;

use KumbiaPHP\ActiveRecord\ActiveRecord;
use KumbiaPHP\Security\Acl\Role\RoleInterface;

/**
 * Description of Roles
 *
 * @author maguirre
 */
class Roles extends ActiveRecord implements RoleInterface
{

    protected function createRelations()
    {
        $this->hasAndBelongsToMany('K2\\Backend\\Model\\Recursos'
                , 'K2\\Backend\\Model\\RolesRecursos');
    }

    public function getName()
    {
        return $this->rol;
    }

    public function getResources()
    {
        return $this->get('K2\\Backend\\Model\\Recursos');
    }

}
