<?php

namespace K2\Backend\Model;

use K2\Kernel\App;
use ActiveRecord\Event\Event;
use K2\ActiveRecord\ActiveRecord;

class Logs extends ActiveRecord
{

    public function addLog(Event $event)
    {
        $modelClass = $event->getModelClass();
        if ($modelClass !== get_class()) {
            $this->create(array(
                'tabla' => $modelClass::table(),
                'usuarios_id' => App::getUser() ? App::getUser()->id : null,
                'sql_query' => $event->getStatement()->getSqlQuery(),
                'query_type' => $event->getQueryType(),
            ));
        }
    }

}
