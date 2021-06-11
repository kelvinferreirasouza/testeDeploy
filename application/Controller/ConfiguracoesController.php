<?php

namespace Ops\Controller;

use Ops\Core\Controller;
use Ops\libs\Util;
use Ops\Model\Menu;
use Ops\Model\ConfigSistema;
use Ops\Model\Estado;
use Ops\Model\ModelGenerico;

class ConfiguracoesController extends FrontController
{
    public $tabela = "configuracoes";
    public $rota = "configuracoes";
    public $dir = "configuracoes";
    public $controller = "configuracoes";

    public function __construct()
    {
        parent::__construct();
    }

    public function geral()
    {
        $menu = (new Menu())->getMenuByRota('configuracoes/geral');

        $config = (new ConfigSistema())->getConfigs();

        $config_empresa = (new ModelGenerico())->getItemByID(1, 'dados_empresa');

        $estados = (new Estado())->getEstados();
        $cidades = (new ModelGenerico())->getAllItensSemAtivo('cidade');

        $this->removeScript(URL . "js/" . VERSAO . "/jquery.min.js");
        $this->removeScript(URL . "js/" . VERSAO . "/toastr.min.js");

        $this->addScript(URL . "js/" . VERSAO . "/configuracoes/gerais.js");

        require APP . 'view/_templates/header.php';
        require APP . 'view/configuracoes/gerais.php';
        require APP . 'view/_templates/footer.php';
    }

    public function updateConfiguracoesGerais()
    {
        if (Util::validaCampos(['cnpj', 'endereco', 'numero_endereco', 'bairro', 'cep', 'estado', 'id_cidade', 'razao_social', 'nome_fantasia', 'email', 'telefone'], $_POST)) {

            $_POST['cnpj'] = Util::formataLimpaString($_POST['cnpj']);
            $_POST['ie'] = Util::formataLimpaString($_POST['ie']);
            $_POST['cep'] = Util::formataLimpaString($_POST['cep']);
            $_POST['telefone'] = Util::formataLimpaString($_POST['telefone']);
            $_POST['celular'] = Util::formataLimpaString($_POST['celular']);

            $estado = (new Estado())->getEstadoByUf($_POST['estado']);

            $_POST['id_estado'] = $estado->id;

            (new ConfigSistema())->updateConfiguracoesGerais($_POST);

            header('location: ' . URL . 'configuracoes/geral?atualizado=true');
            exit;
        }
        header('location: ' . URL . 'configuracoes/geral?atualizado=false');
        exit;
    }
}
