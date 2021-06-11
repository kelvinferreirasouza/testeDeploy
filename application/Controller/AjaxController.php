<?php

namespace Ops\Controller;

use Ops\Model\Estado;
use Ops\Model\Usuario;
use Ops\Model\Vendedor;
use Ops\Model\Plataforma;
use Ops\Model\CelulaDeNegocio;
use Ops\Model\Cartao;

class AjaxController
{

    public function getUsuarioByEmail($email)
    {
        $Usuario = new Usuario();

        if ($Usuario->getUsuarioByEmail($email) != false) {
            echo 'false';
        } else {
            echo 'true';
        };
    }

    public function getVendedorByEmail($email)
    {
        $Vendedor = new Vendedor();

        if ($Vendedor->getVendedorByEmail($email) != false) {
            echo 'false';
        } else {
            echo 'true';
        };
    }

    public function getPlataformaByEmail($email)
    {
        $Plataforma = new Plataforma();

        if ($Plataforma->getPlataformaByEmail($email) != false) {
            echo 'false';
        } else {
            echo 'true';
        };
    }

    public function getCelulaByEmail($email)
    {
        $CelulaDeNegocio = new CelulaDeNegocio();

        if ($CelulaDeNegocio->getCelulaByEmail($email) != false) {
            echo 'false';
        } else {
            echo 'true';
        };
    }

    public function getCidades($id)
    {
        $Estado = new Estado();

        $estados = $Estado->getCidadesByEstado($id);

        echo json_encode($estados);
    }

    public function getCartao($id_cartao)
    {
        $Cartao = new Cartao();

        $cartao = $Cartao->getCartaoById($id_cartao);

        echo json_encode($cartao);
    }
}
