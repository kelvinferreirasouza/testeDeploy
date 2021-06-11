<?php

namespace Ops\Controller;

use Ops\Core\Controller;
use Ops\libs\Util;
use Ops\Model\Menu;
use Ops\Model\Franquia;
use Ops\Model\Estado;
use Ops\Model\ModelGenerico;

class FranquiasController extends FrontController
{
    public $tabela = "franquias";
    public $rota = "franquias";
    public $dir = "franquias";
    public $controller = "franquias";

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        parent::secure_admin();

        $FranquiaModel = new Franquia();
        $Menu = new Menu();

        $menu = (new Menu())->getMenuByRota($this->rota);

        $paginacao = (new ModelGenerico())->paginacao();

        $franquias = $FranquiaModel->getFranquias(10, $paginacao, $_GET);

        $paginacao_proximo = $FranquiaModel->getFranquias(10, $paginacao + 1, $_GET);

        $this->removeScript(URL . "js/" . VERSAO . "/jquery.min.js");
        $this->removeScript(URL . "js/" . VERSAO . "/toastr.min.js");

        require APP . 'view/_templates/header.php';
        require APP . 'view/' . $this->dir . '/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function adicionar()
    {
        parent::secure_admin();

        $menu = (new Menu())->getMenuByRota($this->rota);

        $estados = (new Estado())->getEstados();
        $cidades = (new ModelGenerico())->getAllItensSemAtivo('cidade');

        require APP . 'view/_templates/header.php';
        require APP . 'view/' . $this->dir . '/adicionar.php';
        require APP . 'view/_templates/footer.php';
    }
}
