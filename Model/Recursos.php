<?php

namespace K2\Backend\Model;

use KumbiaPHP\ActiveRecord\ActiveRecord;
use KumbiaPHP\Security\Acl\Resource\ResourceInterface;

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
