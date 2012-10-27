<?php

namespace K2\Backend\Lib;

use \Html;

class DataTable
{

    /**
     * Titulos del las columnas de la tabla
     *
     * @var array
     */
    protected $cabeceras = array();

    /**
     * Campos a mostrar de la tabla
     *
     * @var array
     *
     * <code>
     *  array(
     *      'field' => 'id',
     *      'boolean_field' => 'activo',
     *      'options' => array(
     *          0 => '<a href="/usuarios/editar/%s">Editar</a>'
     *      )
     * )
     * </code>
     */
    protected $campos = array();

    /**
     * Url para el paginador
     *
     * @var string
     */
    protected $url = NULL;

    /**
     * Array de modelos AR
     *
     * @var array ActiveRecord
     */
    protected $model = NULL;

    /**
     * Paginador si se usa
     *
     * @var Paginator
     */
    protected $paginator = NULL;

    /**
     * Tipo de paginador a usar
     *
     * @var string
     */
    protected $typePaginator = NULL;

    /**
     * Indica si se va a crear una tabla con los campos por defecto del modelo
     *
     * @var boolean
     */
    protected $useDefaultFields = TRUE;

    /**
     * Nombre del campo con clave primaria del modelo
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Constructor de la Clase
     *
     * @param array $model Resultado de una consulta ActiveRecord
     */
    public function __construct($model)
    {
        /* @var $model \KumbiaPHP\ActiveRecord\ActiveRecord */
        if (isset($model->items)) {
            $this->paginator = $model;
            $model = $model->items;
        }
        if (sizeof($model) && (current($model) instanceof \KumbiaPHP\ActiveRecord\ActiveRecord)) {
            $this->primaryKey = current($model)->metadata()->getPK();
        }
        $this->model = $model;
    }

    /**
     * Establece|añade los nombres de las cabeceras de las columnas de la tabla
     *
     *
     * Ejemplo:
     *
     * <code>
     *  $obj->addHeaders("nombres","apellidos","cedula");
     *  $obj->addHeaders(array("direccion","telefono"));
     * </code>
     *
     */
    public function addHeaders()
    {
        $params = self::getParams(func_get_args());
        if (isset($params[0]) && is_array($params[0])) {
            $params = $params[0];
        }
        $this->cabeceras = array_merge($this->cabeceras, $params);
    }

    /**
     * Establece|añade los campos del modelo a mostrar en la tabla
     *
     *
     * Ejemplo:
     *
     * <code>
     *  $obj->addFields("nombres","apellidos","cedula");
     *  $obj->addFields("nombres","apellidos","activo: Activo|Inactivo");
     *  $obj->addFields('nombres: tu nombre es : %s','apellidos');
     * </code>
     *
     *
     */
    public function addFields()
    {
        $params = self::getParams(func_get_args());
        if (isset($params[0]) && is_array($params[0])) { //aqui solo debe entrar si son links, imagenes, etc
            $this->campos = array_merge($this->campos, $params);
        } else {
            foreach ($params as $field => $options) {
                if (is_numeric($field)) {
                    $data['field'] = $options;
                    $data['boolean_field'] = FALSE;
                    $data['options'] = array('%s');
                } else {
                    $data['field'] = $field;
                    $options = $options = explode('|', $options);
                    if (count($options) > 1) {
                        $data['boolean_field'] = $data['field'];
                    } else {
                        $data['boolean_field'] = FALSE;
                    }
                    $data['options'] = $options;
                }
                $this->campos[] = $data;
                $this->useDefaultFields = FALSE;
            }
        }
    }

    /**
     * Genera una tabla con los datos del modelo, y muestra la informacion
     * previamente establecida con los metodos headers, fields, etc...
     *
     * @param string $attrs atributos opcionales para la tabla (opcional)
     * @return string tabla generada
     */
    public function render($attrs = NULL)
    {
        $model = $this->model;
        if ($this->useDefaultFields) {
            $this->_getTableSchema($model);
        }
        $table = "<table $attrs>";
//      head de la tabla
        $table .= '<thead>';
        $table .= '<tr style="text-align:center;font-weight:bold;">';
        foreach ($this->cabeceras as $e) {
            $table .= "<th>$e</th>";
        }
        $table .= '</tr>';
        $table .= '</thead>';
//       foot de la tabla
        if ($this->paginator && $this->typePaginator !== FALSE) {
            $table .= '   <tfoot><tr><th colspan="100">';
            $table .= $this->_paginator();
            $table .= '</th></tr></tfoot>';
        } else {
            $table .= '   <tfoot><tr><th colspan="100">';
            $table .= '<span style="float:right;margin-right:20px;"><b>Total registros: ' . count($model) . '</b></span>';
            $table .= '</th></tr></tfoot>';
        }
//      body de la tabla
        $table .= '<tbody>';
        if (sizeof($model)) {
            foreach ($model as $model) {
                $table .= '<tr>';
                foreach ($this->campos as $field) {
                    if (method_exists($model, $field['field'])) { //si es un metodo lo llamamos
                        $value = h($model->$field['field']());
                    } else {
                        $value = h($model->$field['field']);
                    }
                    if ($field['boolean_field']) {
                        $option = $field['options'][$model->$field['boolean_field']];
                    } else {
                        $option = $field['options'][0];
                    }
                    $table .= '<td>' . vsprintf($option, array($value, $value, $value)) . '</td>';
                }
            }
            $table .= '</tr>';
        } else {
            $table .= '<tr><td colspan="100">La Consulta no Arrojó Ningun Registro</td></tr>';
        }
        $table .= '</tbody>';
        $table .= "</table>";
        return $table;
    }

    /**
     *  agrega un check a la tabla
     *
     * @param string $field_name nombre del check
     * @param string $boolean_field campo del modelo que se usará para
     * condicionar la si se muestra ó no el check (opcional)
     */
    public function check($field_name, $boolean_field = NULL)
    {
        $this->addFields(array(
            'field' => $this->primaryKey,
            'boolean_field' => $boolean_field,
            'options' => array(Form::check("$field_name.%s", '%s'), NULL)
        ));
    }

    /**
     * Crea un link en las filas la tabla, por ejemplo la
     * opcion modificar, eliminar, etc
     *
     * @param string $action url ó urls a donde apuntaró el link separados por |
     * @param string $text texto ó textos a mostrar en el link separados por |
     * @param string $boolean_field campo del modelo que se usará para
     * condicionar la url/texto a utilizar en el link (opcional)
     */
    public function link($action, $text, $boolean_field = FALSE)
    {
        $action = explode('|', $action);
        $text = explode('|', $text);
        isset($action[1]) || $action[1] = $action[0];
        isset($text[1]) || $text[1] = $text[0];
        $this->addFields(array(
            'field' => $this->primaryKey,
            'boolean_field' => $boolean_field,
            'options' => array(
                Html::link("$action[0]/%s", $text[0]),
                Html::link("$action[1]/%s", $text[1]),
            )
        ));
    }

    /**
     * Crea un link con una imagen en las filas la tabla, por ejemplo la
     * opcion modificar, eliminar, etc
     *
     * @param string $url_img direccion ó direcciones donde se encuentra la imagen separados por |
     * @param string $text texto ó textos a mostrar al lado de la imagen separados por | (opcional)
     * @param string $boolean_field campo del modelo que se usará para
     * condicionar la url/texto a utilizar en el link (opcional)
     */
    public function img($url_img, $text = NULL, $boolean_field = FALSE)
    {
        $url_img = explode('|', $url_img);
        $text = explode('|', $text);
        isset($action[1]) || $action[1] = $action[0];
        isset($text[1]) || $text[1] = $text[0];
        $this->addFields(array(
            'field' => $this->primaryKey,
            'boolean_field' => $boolean_field,
            'options' => array(
                Html::img($action[0], $text[0]),
                Html::img($action[1], $text[1]),
            )
        ));
    }

    /**
     * Crea un link con una imagen en las filas la tabla, por ejemplo la
     * opcion modificar, eliminar, etc
     *
     * @param string $url_img direccion ó direcciones donde se encuentra la imagen separados por |
     * @param string $action url ó urls a donde apuntaró el link separados por |
     * @param string $text texto ó textos a mostrar al lado de la imagen separados por | (opcional)
     * @param string $boolean_field campo del modelo que se usará para
     * condicionar la url/texto a utilizar en el link (opcional)
     */
    public function imgLink($url_img, $action, $text = NULL, $boolean_field = NULL)
    {
        $url_img = explode('|', $url_img);
        $action = explode('|', $action);
        $text = explode('|', $text);
        isset($url_img[1]) || $url_img[1] = $url_img[0];
        isset($action[1]) || $action[1] = $action[0];
        isset($text[1]) || $text[1] = $text[0];
        $this->addFields(array(
            'field' => $this->primaryKey,
            'boolean_field' => $boolean_field,
            'options' => array(
                Html::link("$action[0]/%s", Html::img($url_img[0]) . " $text[0]"),
                Html::link("$action[1]/%s", Html::img($url_img[1]) . " $text[1]"),
            )
        ));
    }

    /**
     * Crea un link en las filas la tabla, por ejemplo la
     * opcion modificar, eliminar, etc
     *
     * @param string $action url ó urls a donde apuntaró el link separados por |
     * @param string $text texto ó textos a mostrar en el link separados por |
     * @param string $confirm pregunta/s a mostrar en el link separados por |
     * @param string $boolean_field campo del modelo que se usará para
     * condicionar la url/texto a utilizar en el link (opcional)
     */
    public function linkConfirm($action, $text, $confirm = '¿Esta Seguro?', $boolean_field = FALSE)
    {
        $action = explode('|', $action);
        $text = explode('|', $text);
        $confirm = explode('|', $confirm);
        isset($action[1]) || $action[1] = $action[0];
        isset($text[1]) || $text[1] = $text[0];
        isset($confirm[1]) || $confirm[1] = $confirm[0];
        $this->addFields(array(
            'field' => $this->primaryKey,
            'boolean_field' => $boolean_field,
            'options' => array(
                Js::link("$action[0]/%s", $text[0], $confirm[0]),
                Js::link("$action[1]/%s", $text[1], $confirm[1]),
            )
        ));
    }

    /**
     * Crea un link con una imagen en las filas la tabla, por ejemplo la
     * opcion modificar, eliminar, etc
     *
     * @param string $url_img direccion ó direcciones donde se encuentra la imagen separados por |
     * @param string $action url ó urls a donde apuntaró el link separados por |
     * @param string $text texto ó textos a mostrar al lado de la imagen separados por | (opcional)
     * @param string $confirm pregunta/s a mostrar en el link separados por |
     * @param string $boolean_field campo del modelo que se usará para
     * condicionar la url/texto a utilizar en el link (opcional)
     */
    public function imgLinkConfirm($url_img, $action, $text = NULL, $confirm = '¿Esta Seguro?', $boolean_field = NULL)
    {
        $url_img = explode('|', $url_img);
        $action = explode('|', $action);
        $text = explode('|', $text);
        $confirm = explode('|', $confirm);
        isset($url_img[1]) || $url_img[1] = $url_img[0];
        isset($action[1]) || $action[1] = $action[0];
        isset($text[1]) || $text[1] = $text[0];
        isset($confirm[1]) || $confirm[1] = $confirm[0];
        $this->addFields(array(
            'field' => $this->primaryKey,
            'boolean_field' => $boolean_field,
            'options' => array(
                Js::link("$action[0]/%s", Html::img($url_img[0]) . " $text[0]", $confirm[0]),
                Js::link("$action[1]/%s", Html::img($url_img[1]) . " $text[1]", $confirm[1]),
            )
        ));
    }

    /**
     * Establece la url para el paginador, si no se estable usa el
     * modulo/controlador/accion actual.
     *
     * Ejemplo:
     *
     * <code>
     *      $obj->url('usuarios/index');
     * </code>
     *
     * @param string $url
     */
    public function url($url)
    {
        $this->url = "$url/";
    }

    /**
     * Establece el paginador de kumbia a utilizar en la tabla,
     * si no se estable utiliza uno interno del helper
     *
     * @param string $paginator
     */
    public function typePaginator($paginator)
    {
        $this->typePaginator = $paginator;
    }

    protected function _paginator()
    {
        $this->url = \KumbiaPHP\View\View::get('app.context')->createUrl();
        if (!$this->typePaginator) {
            $html = '<div class="paginador-tabla">';
            if ($this->paginator->count > $this->paginator->per_page) {
                if ($this->paginator->prev) {
                    $html .= Html::link($this->url . $this->paginator->prev, 'Anterior', 'title="Ir a la p&aacute;g. anterior"');
                    $html .= '&nbsp;&nbsp;';
                }
                for ($x = 1; $x <= $this->paginator->total; ++$x) {
                    $html .= $this->paginator->current == $x ? '<b>' . $x . '</b>' : Html::link($this->url . $x, $x);
                    $html .= '&nbsp;&nbsp;';
                }
                if ($this->paginator->next) {
                    $html .= Html::link($this->url . $this->paginator->next, 'Siguiente', 'title="Ir a la p&aacute;g. siguiente"');
                }
            }
            $html .= '<span style="float:right;margin-right:20px;"><b>Total registros: ' . $this->paginator->count . '</b></span></div>';
            return $html;
        } else {
            $parametros = array(
                'page' => $this->paginator,
                'url' => substr($this->url, 0, strlen($this->url) - 1)
            );
            ob_start();
            \KumbiaPHP\View\View::partial('paginators/' . $this->typePaginator, false, $parametros);
            $paginador = ob_get_contents();
            ob_get_clean();
            return $paginador;
        }
    }

    /**
     * Indica los nombres de las columnas y los campos a mostrar por defecto
     * del Modelo si no se especifican ningunos en ninun momento
     *
     * @param ActiveRecord $model modelo del que se hará la lista
     */
    protected function _getTableSchema($model)
    {
        if ($model) {
            $temp_campos = $this->campos;
            $temp_cabeceras = $this->cabeceras;
            $this->campos = array();
            $this->cabeceras = array();
            $fields = array();
            $alias = array();
            foreach(current($model)->metadata()->getAttributes() as $name => $attr){
                $fields[] = $name;
                $alias[] = $attr->alias;
            }
            call_user_func_array(array($this, 'addFields'), $fields);
            call_user_func_array(array($this, 'addHeaders'), $fields);
            $this->campos = array_merge($this->campos, $temp_campos);
            $this->cabeceras = array_merge($this->cabeceras, $temp_cabeceras);
        }
    }

    protected function getParams($params)
    {
        $data = array();
        foreach ($params as $p) {
            if (is_string($p)) {
                $match = explode(': ', $p, 2);
                if (isset($match[1])) {
                    $data[$match[0]] = $match[1];
                } else {
                    $data[] = $p;
                }
            } else {
                $data[] = $p;
            }
        }
        return $data;
    }

}