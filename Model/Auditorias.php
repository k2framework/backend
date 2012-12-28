<?php

namespace K2\Backend\Model;

use K2\ActiveRecord\ActiveRecord;

/**
 * Description of Auditorias
 *
 * @author manuel
 */
class Auditorias extends ActiveRecord
{

    protected function initialize()
    {
        $this->belongsTo('K2\\Backend\\Model\\Usuarios', 'usuarios_id');
    }

}