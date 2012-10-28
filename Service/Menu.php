<?php

namespace K2\Backend\Service;

use K2\Backend\Model\Menus;
use KumbiaPHP\Security\Security;
use K2\Backend\Model\MenuInterface;

/**
 * Description of Menu
 *
 * @author maguirre
 */
class Menu
{

    const BACKEND = 1;
    const APP = 2;

    /**
     *
     * @var Security 
     */
    protected $security;

    public function __construct(Security $s)
    {
        $this->security = $s;
    }

    public function render($entorno = self::BACKEND)
    {
        $registros = Menus::getItems($entorno);
        $html = '';
        if ($registros) {
            $html .= '<ul class="nav">' . PHP_EOL;
            foreach ($registros as $e) {
                $html .= $this->generarItem($e, $entorno);
            }
            $html .= '</ul>' . PHP_EOL;
        }
        return $html;
    }

    protected function generarItem(MenuInterface $menu, $entorno)
    {
        if ($this->security->hasPermissions($menu->getUrl())) {
            $sub_menus = $menu->hasSubItems(); //verifica que existan items hijos
            $class = 'menu_' . str_replace('/', '_', $menu->getUrl()); //la url formará parte de las clases
            $class .= ' ' . h($menu->getClasses()); //obtenemos las clases del item actual
            if ($sub_menus) { //si tiene items hijos
                $html = "<li class='" . h($class) . " dropdown'>" .
                        \Html::link($menu->getUrl() . '#', h($menu->getTitle()) .
                                ' <b class="caret"></b>', 'class="dropdown-toggle" data-toggle="dropdown"') . PHP_EOL;
            } else {
                $html = "<li class='" . h($class) . "'>" .
                        \Html::link($menu->getUrl(), h($menu->getTitle())) . PHP_EOL;
            }
            if ($sub_menus) {
                $html .= '<ul class="dropdown-menu">' . PHP_EOL;
                foreach ($menu->getSubItems() as $e) {
                    $html .= $this->generarItem($e, $entorno);
                }
                $html .= '</ul>' . PHP_EOL;
            }
            return $html . "</li>" . PHP_EOL;
        }
    }

}
