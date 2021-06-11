<?php

namespace Ops\Controller;

use Ops\Core\Controller;
use Ops\libs\Util;
use Ops\libs\FuncaoArray;
use Ops\Model\Menu;
use Ops\Model\Categoria;
use Ops\Model\ModelGenerico;

class CategoriasController extends FrontController
{
    public $tabela = "categorias";
    public $rota = "categorias";
    public $dir = "categorias";
    public $controller = "categorias";

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        parent::secure_admin();

        $CategoriaModel = new Categoria();

        $menu = (new Menu())->getMenuByRota($this->rota);

        $paginacao = (new ModelGenerico())->paginacao();

        $categorias = $CategoriaModel->getCategorias(10, $paginacao, $_GET);
        $paginacao_proximo = $CategoriaModel->getCategorias(10, $paginacao + 1, $_GET);

        $this->removeScript(URL . "js/" . VERSAO . "/jquery.min.js");
        $this->removeScript(URL . "js/" . VERSAO . "/toastr.min.js");

        require APP . 'view/_templates/header.php';
        require APP . 'view/' . $this->dir . '/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function adicionar()
    {
        parent::secure_admin();

        $CategoriaModel = new Categoria();

        $menu = (new Menu())->getMenuByRota($this->rota);

        require APP . 'view/_templates/header.php';
        require APP . 'view/' . $this->dir . '/adicionar.php';
        require APP . 'view/_templates/footer.php';
    }

    public function adicionarCategoria()
    {
        $CategoriaModel = new Categoria();

        if (Util::validaCampos(['nome'], $_POST)) {

            $id_categoria = $CategoriaModel->insertCategoria($_POST['nome']);

            if (isset($_FILES['imagem'])) {

                $a = new FuncaoArray();
                $imagens = $a->reArrayFiles($_FILES['imagem']);  //Arruma os índices do array $_FILES

                foreach ($imagens as $imagem) {

                    if ($imagem['type'] == 'image/jpeg' || $imagem['type'] == 'image/png') {

                        $upload = $CategoriaModel->uploadImagem($imagem);

                        if ($upload['error']) {
                            header('location: ' . URL . $this->dir . '?cadastrado=false');
                            exit;
                        } else {
                            $CategoriaModel->salvaImagem($id_categoria, $upload['filename'], $upload['filename_md']);

                            header('location: ' . URL . $this->dir . '/editar/' . $id_categoria . '?cadastrado=true');
                            exit;
                        }
                    } else {
                        header('location: ' . URL . $this->dir . '?cadastrado=false');
                        exit;
                    }
                }
            }
        }
    }

    public function editar($id_categoria)
    {
        parent::secure_admin();

        $CategoriaModel = new Categoria();

        $menu = (new Menu())->getMenuByRota($this->rota);

        $categoria = (new ModelGenerico())->getItemByID($id_categoria, 'categoria');

        $categoria_imagens = (new ModelGenerico())->getItemByCampoGenerico($id_categoria, 'categoria_imagem', 'id_categoria');

        $this->addStyle(URL . "css/" . VERSAO . "/categoria.css");

        require APP . 'view/_templates/header.php';
        require APP . 'view/' . $this->dir . '/adicionar.php';
        require APP . 'view/_templates/footer.php';
    }

    public function editarCategoria($id_categoria)
    {
        if (Util::validaCampos(['nome'], $_POST)) {

            $CategoriaModel = new Categoria();

            if (isset($_FILES) && $_FILES['imagem']['size'][0] != 0) {
                $CategoriaModel->updateCategoriaById($id_categoria, $_POST, $_FILES);
            } else {
                $CategoriaModel->updateCategoriaById($id_categoria, $_POST);
            }

            header('location: ' . URL . $this->dir . '/editar/' . $id_categoria . '?atualizado=true');
            exit;
        } else {
            header('location: ' . URL . $this->dir . '/editar/' . $id_categoria . '?atualizado=false');
            exit;
        }
    }

    public function deletarImagem()
    {
        if (isset($_POST['imagem']) && $_POST['imagem'] != "") {

            foreach ($_POST['imagem'] as $imagem) {
                $img = explode("&", $imagem);
                $id_imagem = $img[0];
                $nome = $img[1];

                if (isset($id_imagem)) {
                    (new Categoria())->deletarImagem($id_imagem, $nome);
                }
            }
        }

        header('location: ' . URL . $this->dir . '/editar/' . $_POST['id_categoria'] . '?imgExcluida=true');
        exit;
    }

    public function desativar($id_categoria)
    {
        if (isset($id_categoria) && $id_categoria != "") {

            (new ModelGenerico())->desativarItem($id_categoria, 'categoria');

            header('location: ' . URL . $this->dir . '?desativado=true');
            exit;
        } else {
            header('location: ' . URL . $this->dir . '?desativado=false');
            exit;
        }
    }

    public function ativar($id_categoria)
    {
        if (isset($id_categoria) && $id_categoria != "") {

            (new ModelGenerico())->ativarItem($id_categoria, 'categoria');

            header('location: ' . URL . $this->dir . '?ativado=true');
            exit;
        } else {
            header('location: ' . URL . $this->dir . '?ativado=false');
            exit;
        }
    }
}
