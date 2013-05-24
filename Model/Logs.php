<?php

namespace K2\Backend\Model;

use K2\Kernel\App;
use K2\ActiveRecord\ActiveRecord;
use ActiveRecord\Adapter\Adapter;
use ActiveRecord\Event\Event;

class Logs extends ActiveRecord
{

    public function addLog(Event $event)
    {
        if ($event->getModelClass() !== get_class()) {
            $this->create(array(
                'usuarios_id' => App::getUser()->id,
                'query' => $event->getStatement()->getSqlQuery(),
                'query_type' => $event->getQueryType(),
            ));
        }
    }

}
