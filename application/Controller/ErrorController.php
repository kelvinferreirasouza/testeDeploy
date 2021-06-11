<?php

namespace Ops\Controller;

use Ops\Core\Controller;

class ErrorController extends FrontController
{
    public function index()
    {
        require APP . 'view/_templates/header.php';
        require APP . 'view/error/index.php';
        require APP . 'view/_templates/footer.php';
    }
}
