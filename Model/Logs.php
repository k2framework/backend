<?php

namespace K2\Backend\Model;

use K2\Kernel\App;
use K2\ActiveRecord\ActiveRecord;
use ActiveRecord\Adapter\Adapter;
use ActiveRecord\Event\QueryEvent;

class Logs extends ActiveRecord
{

    public function addLog(QueryEvent $event)
    {
        //var_dump(get_class($event->getModelClass()));
//        if ($event->getModel() !== get_class()) {
//            $adapter = Adapter::factory();
//            $query = $adapter->createQuery()
//                    ->insert(array(
//                'usuarios_id' => App::getUser()->id,
//                'sql' => $event->getStatement()->getSqlQuery(),
//                'type' => $event->getQueryType(),
//            ))->table(static::table());
//
//            $statement = $adapter->prepareDbQuery($query);
//            
//            try{
//                var_dump($query->getSqlArray());
//            $statement->execute($query->getBind());
//                
//            }catch(\Exception $e){
//                var_dump($statement->getSqlQuery());die;
//            }
//        }
    }

}
