<?php

namespace K2\Backend\Model;

use K2\Backend\Model\Roles;
use K2\ActiveRecord\ActiveRecord;

/**
 * Description of Roles
 *
 * @author maguirre
 */
class RolesRecursos extends ActiveRecord
{

    /**
     * Actualiza los privilegios para Un Rol en especifico
     * @param array $privilegios arreglo con los privilegios
     * @param array $seleccionados arreglo con los id seleccionados.
     */
    public static function editar(Roles $rol, array $privilegios, array $seleccionados)
    {
        $eliminar = array();
        $existentes = array();
        //obtenemos todos los privilegios y los recorremos
        //vamos verificando si se ha deseleccionado un elemento 
        //ó aun sigue seleccionado
        //y vamos llenando un arreglo con los deseleccionados ($eliminar) para eliminarlos de la BD
        //y otro arreglo con los existentes ($existentes) para no agregarlos a la BD
        foreach ($privilegios as $re) {
            if (null === $re->id) {
                continue;
            } elseif (!$re->isSelected($rol, $seleccionados)) {
                //si el recurso no está seleccionado, lo vamos a eliminar
                $eliminar[] = $re->id;
            } else {
                $existentes[] = $re->recursos_id;
            }
        }
        //los elementos a agregar son los seleccionados que no existen aun en la BD
        $agregar = array_diff($seleccionados, $existentes);

        $model = new static();

        return $model->transaction(function($model)use($rol, $agregar, $eliminar) {
                            //eliminamos los elementos deseleccionados
                            $model::deleteByIds($eliminar);
                            foreach ($agregar as $id) {
                                $model->roles_id = $rol->id;
                                $model->recursos_id = (int) $id;
                                if (!$model->create()) {
                                    return false;
                                }
                            }
                        });
    }

    /**
     * Verifica que el objeto aparesca en el arreglo de ids seleccionados.
     * @param Roles $rol
     * @param array $selecteds arreglo de ids, ejemplo: array(2,4,67,100,...);
     * @return booblean 
     */
    public function isSelected(Roles $rol, array $selecteds)
    {
        return $this->roles_id === $rol->id && in_array($this->recursos_id, $selecteds);
    }

    public static function deleteByIds(array $ids)
    {
        if (count($ids)) {
            $query = self::createQuery();

            static::createConditions($query, array('id' => $ids));

            self::deleteAll($query);
        }
    }

}
