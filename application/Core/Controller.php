<?php

namespace Ops\Core;

use Ops\Model\Usuario;
use Ops\Model\Menu;
use Ops\Model\ConfigSistema;

class Controller
{
    public $menu = null;
    public $paginas = null;
    public $config_sistema = null;

    public function __construct()
    {
        $this->menu = new Menu();
        $this->config_sistema = (new ConfigSistema())->getConfigs();

        $Usuario = new Usuario();

        $Usuario->checaSessao();

        $usuario = $Usuario->getUsuarioById($_SESSION['ops']['id']);

        if ($usuario->id_perfil == 1) { //ADMINISTRADOR
            $this->paginas = $this->menu->getMenu();
        }
    }

    public static function secure_admin()
    {
        if ($_SESSION['ops']['nivel'] != 10) {
            header('location: ' . URL . 'home/');
            exit;
        }
    }
}
