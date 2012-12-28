<?php

namespace K2\Backend\Model;

use K2\ActiveRecord\ActiveRecord;
use K2\Security\Acl\Resource\ResourceInterface;

/**
 * Description of Recursos
 *
 * @author maguirre
 */
class Recursos extends ActiveRecord implements ResourceInterface
{

    public function getName()
    {
        return $this->recurso;
    }

}
