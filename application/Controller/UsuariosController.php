<?php

namespace Ops\Controller;

use Ops\Core\Controller;
use Ops\libs\Util;
use Ops\Model\Menu;
use Ops\Model\Usuario;
use Ops\Model\ModelGenerico;

class UsuariosController extends FrontController
{
    public $tabela = "usuarios";
    public $rota = "usuarios";
    public $dir = "usuarios";
    public $controller = "usuarios";

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        parent::secure_admin();

        $Usuario = new Usuario();
        $Menu = new Menu();

        $menu = (new Menu())->getMenuByRota($this->rota);

        $paginacao = $Usuario->paginacao();
        $usuarios = $Usuario->getUsuarios(10, $paginacao, $_GET);
        $paginacao_proximo = $Usuario->getUsuarios(10, $paginacao + 1, $_GET);

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

        $usuarios_perfil = (new ModelGenerico())->getAllItensSemAtivo('usuario_perfil');

        require APP . 'view/_templates/header.php';
        require APP . 'view/' . $this->dir . '/adicionar.php';
        require APP . 'view/_templates/footer.php';
    }

    public function editar($id_usuario)
    {
        parent::secure_admin();

        $menu = (new Menu())->getMenuByRota($this->rota);

        $usuario = (new Usuario())->getUsuarioById($id_usuario);

        $usuarios_perfil = (new ModelGenerico())->getAllItensSemAtivo('usuario_perfil');

        $this->removeScript(URL . "js/" . VERSAO . "/jquery.min.js");
        $this->removeScript(URL . "js/" . VERSAO . "/toastr.min.js");

        require APP . 'view/_templates/header.php';
        require APP . 'view/' . $this->dir . '/editar.php';
        require APP . 'view/_templates/footer.php';
    }

    public function cadastrarUsuario()
    {
        if (isset($_POST["cadastrar"])) {

            if (Util::validaCampos(['senha', 'confirmar_senha'], $_POST)) {

                if ($_POST["senha"] == $_POST["confirmar_senha"]) {

                    $Usuario = new Usuario();

                    if ($Usuario->getUsuarioByEmail($_POST["email"]) == false) {

                        $Usuario->insertUsuario($_POST);

                        header('location: ' . URL . $this->dir . '?cadastrado=true');
                        exit;
                    } else {
                        header('location: ' . URL . $this->dir . '?emailExiste=true');
                        exit;
                    }
                }
            }
        }

        header('location: ' . URL . $this->dir);
        exit;
    }

    public function updateUsuario($id_usuario)
    {
        if (isset($_POST["editar"])) {

            $Usuario = new Usuario();

            $usuario = $Usuario->getUsuarioById($id_usuario);

            if (Util::validaCampos(['senha', 'confirmar_senha'], $_POST)) {
                if ($_POST["senha"] == $_POST["confirmar_senha"]) {
                    $senha = md5($_POST["senha"]);
                } else {
                    header('location: ' . URL . $this->dir);
                    exit;
                }
            } else {
                $senha = $usuario->senha;
            }

            if (Util::validaCampos(['email'], $_POST)) {
                if ($_POST['email'] == $usuario->email) {
                    $email = $usuario->email;
                } else {
                    if ($Usuario->getUsuarioByEmail($_POST['email']) != true) {
                        $email = $_POST['email'];
                    } else {
                        header('location: ' . URL . $this->dir . '?emailcadastrado=true');
                        exit;
                    }
                }
            }

            $arrayDados = [];

            if ($usuario->id_perfil != $_POST['id_perfil']) {
                $perfil = (new ModelGenerico())->getItemByID($_POST['id_perfil'], 'usuario_perfil');

                $arrayDados['nivel'] = $perfil->nivel;
                $arrayDados['id_perfil'] = $_POST['id_perfil'];
            } else {
                $arrayDados['nivel'] = $usuario->nivel;
                $arrayDados['id_perfil'] = $_POST['id_perfil'];
            }

            $arrayDados['id_usuario'] = $id_usuario;
            $arrayDados['nome'] = $_POST['nome'];
            $arrayDados['email'] = $email;
            $arrayDados['senha'] = $senha;
            $arrayDados['telefone'] = $_POST['telefone'];
            $arrayDados['celular'] = $_POST['celular'];
            $arrayDados['ativo'] = $_POST['ativo'];

            $Usuario->updateUsuario($arrayDados);

            header('location: ' . URL . $this->dir . '?atualizado=true');
            exit;
        }

        header('location: ' . URL . $this->dir);
        exit;
    }

    public function desativarusuario($id_usuario)
    {
        if (isset($id_usuario)) {
            if (isset($_POST['desativar'])) {
                $Usuario = new Usuario();
                $Usuario->desativaUsuario($id_usuario);

                header('location: ' . URL . $this->dir . '?desativado=true');
                exit;
            }
        }

        header('location: ' . URL . $this->dir);
        exit;
    }

    public function ativarusuario($id_usuario)
    {
        if (isset($id_usuario)) {
            if (isset($_POST['ativar'])) {
                $Usuario = new Usuario();

                $Usuario->ativaUsuario($id_usuario);

                header('location: ' . URL . $this->dir . '?ativavo=true');
                exit;
            }
        }

        header('location: ' . URL . $this->dir);
        exit;
    }
}
