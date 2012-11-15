<?php

namespace K2\Backend\Model;

use K2\Backend\Model\MenuInterface;
use KumbiaPHP\ActiveRecord\ActiveRecord;

/**
 * Description of Menus
 *
 * @author maguirre
 */
class Menus extends ActiveRecord implements MenuInterface
{

    protected function createRelations()
    {
        $this->hasMany(__CLASS__);
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
        self::createQuery()
                ->order("posicion ASC")
                ->where("menus_id = :id")
                ->where("activo = TRUE")
                ->bindValue('id', $this->id);
        return self::findAll();
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
                ->bindValue('id', $this->id);
        return self::count();
    }

    public function getId()
    {
        return $this->id;
    }

}
