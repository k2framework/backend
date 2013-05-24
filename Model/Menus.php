<?php

namespace K2\Backend\Model;

use K2\Backend\Model\MenuInterface;
use K2\ActiveRecord\ActiveRecord;

/**
 * Description of Menus
 *
 * @author maguirre
 */
class Menus extends ActiveRecord implements MenuInterface
{

    protected function createRelations()
    {
        $this->belongsTo('padre', __CLASS__, 'menus_id');
        $this->hasMany('hijos', __CLASS__, 'menus_id');
    }

    public function getClasses()
    {
        return $this->clases;
    }

    public static function getItems($entorno)
    {
        self::createQuery()
                ->order("posicion ASC")
                ->where("visible_en = :entorno")
                ->where("menus_id is NULL")
                ->where("activo = TRUE")
                ->bindValue('entorno', $entorno);
        return self::findAll();
    }

    public function getSubItems()
    {
        return $this->getHijos(array('menus.activo' => true));
    }

    public function getTitle()
    {
        return $this->nombre;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function hasSubItems()
    {
        self::createQuery()
                ->where("menus_id = :id")
                ->where("activo = 1")
                ->bindValue('id', $this->id);
        return self::count();
    }

    public function getId()
    {
        return isset($this->id) ? $this->id : null;
    }

    public function getPadre()
    {
        return $this->get('padre');
    }

}
