<?php

namespace K2\Backend\Model;

/**
 * Interfaz para la implementación de Menus para el backend.
 * 
 * Pueden ser menus por base de datos, arreglos, archivos .ini , etc.
 * 
 * El entorno sirve para usar la misma clase en distintas partes de la app,
 * y dependiendo del entorno se mostrarán unos elementos del mení u otros.
 *
 * @author Manuel Aguirre manuel_j555 <programador.manuel@gmail.com>
 * */
interface MenuInterface
{

    /**
     * Devuelve un array de Objetos MenuInterface que son los items
     * principales que tendrá el menu para el entorno indicado
     * 
     * @param string $entorno indica el entorno del menú
     * @return array(MenuInterface) devuelve un array con objetos MenuInterface
     */
    public static function getItems($entorno);

    /**
     * Devuelve los items (MenuInterface) hijos del menu item actual
     * 
     * @return array(MenuInterface) devuelve un array con objetos MenuInterface
     */
    public function getSubItems();

    /**
     * Verifica si el menu actual posee items hijos
     * 
     * @return boolan
     */
    public function hasSubItems();

    /**
     * Devuelve la url del item
     * 
     * @return string
     */
    public function getUrl();

    /**
     * Devuelve la url del item
     * 
     * @return string
     */
    public function getId();

    /**
     * 
     * Devuelve las clases (para css) del item
     * 
     * @return string 
     */
    public function getClasses();

    /**
     * Devuelve el texto del item
     * 
     * @return string 
     */
    public function getTitle();
}