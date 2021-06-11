<?php

namespace Ops\Controller;

use Ops\Core\Controller;
use Ops\Model\Usuario;

class HomeController extends FrontController
{

    public function index()
    {
        $Usuario = new Usuario();

        header('location: ' . URL . "home/usuario");
        exit;
    }

    public function usuario()
    {
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }
}
