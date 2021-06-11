<?php

namespace Ops\Controller;

use Ops\Model\Usuario;

class LoginController
{

    public function verificaSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function index()
    {
        $this->verificaSession();

        if (!isset($_SESSION['ops']['nivel'])) {

            require APP . 'view/login/index.php';
        } else {
            header('location: ' . URL . 'home/index');
            exit;
        }
    }

    public function logar()
    {
        $this->verificaSession();

        if (isset($_POST['login'])) {

            if ($_POST['senha'] != "" && $_POST['email'] != "") {

                $_POST['email'] = strtoupper($_POST['email']);

                $Usuario = new Usuario();

                if ($Usuario->getUsuarioByEmail($_POST['email']) == true) {

                    $usuario = $Usuario->getUsuarioByEmail($_POST['email']);

                    if (md5($_POST['senha']) == $usuario->senha && $usuario->ativo == 1) {

                        $_SESSION['ops']['id'] = $usuario->id_usuario;
                        $_SESSION['ops']['email'] = $usuario->email;
                        $_SESSION['ops']['nivel'] = $usuario->nivel;
                        $_SESSION['ops']['nome'] = $usuario->nome;

                        if ($usuario->nivel == 0) {
                            header('location: ' . URL . "configuracoes/usuarios/");
                            exit;
                        } else if ($usuario->nivel == 10) {
                            header('location: ' . URL . "/home");
                            exit;
                        }
                    } else {
                        header('location: ' . URL . 'login/index?dadosincorretos=true');
                    }
                } else {
                    header('location: ' . URL . 'login/index?dadosincorretos=true');
                }
            } else {
                header('location: ' . URL . 'login/index?dadosincorretos=true');
            }
        } else {
            header('location: ' . URL . 'login/index');
        }
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['ops']);
        header('location: ' . URL . 'login/index');
    }
}
