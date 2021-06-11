<?php

namespace Ops\Controller;

use Ops\Core\Controller;
use Ops\Model\Menu;
use Ops\Model\GerenciaPost;
use Ops\Model\ModelGenerico;
use Ops\Model\Cliente;
use Ops\Model\Estado;

use Ops\libs\Util;

class ClientesController extends FrontController {
    public $tabela = "cliente";
    public $dir = "clientes";
    public $rota = "clientes";
    public $controller = "clientes";

    const ID_TIPO_PESSOA_FISICA = 1;
    const ID_TIPO_PESSOA_JURIDICA = 2;

    public function __construct()
    {
        parent::__construct();
        $this->addScript(URL . "js/" . VERSAO . "/estado-cidade.js");
        $this->addScript(URL . "js/" . VERSAO . "/cadastro_cliente.js");
    }

    public function index() {
       
        $Menu = new Menu();
        
        $menu = $Menu->getMenuByRota($this->rota);
        $paginacao = (new ModelGenerico())->paginacao();
        
        $clientes = (new Cliente())->getClientes(10, $paginacao, $_GET);
        $paginacao_proximo = (new Cliente())->getClientes(10, $paginacao + 1, $_GET);
        
        if(!isset($_GET['ativo'])){
            $_GET['ativo'] = 1;
        }
        
        require APP . 'view/_templates/header.php';
        require APP . 'view/'.$this->dir.'/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function adicionar(){
        $Menu = new Menu();

        $menu = $Menu->getMenuByRota($this->rota);
        $estados = (new Estado())->getEstados();
        $tiposCliente = (new Cliente())->getTiposCliente();
        
        require APP . 'view/_templates/header.php';
        require APP . 'view/'.$this->dir.'/adicionar.php';
        require APP . 'view/_templates/footer.php';
    }
    
    public function editar($id){
        $Menu = new Menu();
        $menu = $Menu->getMenuByRota($this->rota);
        $estados = (new Estado())->getEstados();
        $tiposCliente = (new Cliente())->getTiposCliente();
        
        $obj = (new ModelGenerico())->getItemByID($id, $this->tabela);
  
        require APP . 'view/_templates/header.php';
        require APP . 'view/'.$this->dir.'/adicionar.php';
        require APP . 'view/_templates/footer.php';
    }
    
    public function adicionarCliente(){
        
        if(isset($_POST['nome']) && $_POST['nome'] != ""){
            
            $arrayPost['nome'] = $_POST['nome'];
            $arrayPost['email'] = $_POST['email'];
            $arrayPost['cpf_cnpj'] = Util::formataLimpaString($_POST['cpf_cnpj']);
            $arrayPost['rg_ie'] = Util::formataLimpaString($_POST['rg_ie']);
            $arrayPost['telefone'] = Util::formataLimpaString($_POST['telefone']);
            $arrayPost['celular'] = Util::formataLimpaString($_POST['celular']);
            $arrayPost['cep'] = Util::formataLimpaString($_POST['cep']);
            $arrayPost['uf_estado'] = $_POST['uf_estado'];
            $arrayPost['id_cidade'] = $_POST['id_cidade'];
            $arrayPost['endereco'] = $_POST['endereco'];
            $arrayPost['numero_endereco'] = $_POST['numero_endereco'];
            $arrayPost['bairro'] = $_POST['bairro'];

            $arrayPost['id_tipo_cliente'] = $_POST['id_tipo_cliente'];

            $arrayPost['razao_social'] = "";
            $arrayPost['nome_responsavel_empresa'] = "";
            $arrayPost['cpf_responsavel_empresa'] = "";

            if(self::ID_TIPO_PESSOA_JURIDICA == $arrayPost['id_tipo_cliente']){
                $arrayPost['razao_social'] = $_POST['razao_social'];
                $arrayPost['nome_responsavel_empresa'] = $_POST['nome_responsavel_empresa'];
                $arrayPost['cpf_responsavel_empresa'] = Util::formataLimpaString($_POST['cpf_responsavel_empresa']);
            }
            
            (new GerenciaPost())->insert($arrayPost, $this->tabela, true);

        }
        header('location: ' . URL . $this->rota); exit;
    }

    public function editarCliente($id){
        $Obj = new ModelGenerico();
        $obj = $Obj->getItemByID($id, $this->tabela);
      
        if ($_POST['nome'] != "") {
            
            $arrayPost['nome'] = $_POST['nome'];
            $arrayPost['email'] = $_POST['email'];
            $arrayPost['cpf_cnpj'] = Util::formataLimpaString($_POST['cpf_cnpj']);
            $arrayPost['rg_ie'] = Util::formataLimpaString($_POST['rg_ie']);
            $arrayPost['telefone'] = Util::formataLimpaString($_POST['telefone']);
            $arrayPost['celular'] = Util::formataLimpaString($_POST['celular']);
            $arrayPost['cep'] = Util::formataLimpaString($_POST['cep']);
            $arrayPost['uf_estado'] = $_POST['uf_estado'];
            $arrayPost['id_cidade'] = $_POST['id_cidade'];
            $arrayPost['endereco'] = $_POST['endereco'];
            $arrayPost['numero_endereco'] = $_POST['numero_endereco'];
            $arrayPost['bairro'] = $_POST['bairro'];
            $arrayPost['ativo'] = $_POST['ativo'];

            $arrayPost['id_tipo_cliente'] = $_POST['id_tipo_cliente'];

            $arrayPost['razao_social'] = "";
            $arrayPost['nome_responsavel_empresa'] = "";
            $arrayPost['cpf_responsavel_empresa'] = "";

            if(self::ID_TIPO_PESSOA_JURIDICA == $arrayPost['id_tipo_cliente']){
                $arrayPost['razao_social'] = $_POST['razao_social'];
                $arrayPost['nome_responsavel_empresa'] = $_POST['nome_responsavel_empresa'];
                $arrayPost['cpf_responsavel_empresa'] = Util::formataLimpaString($_POST['cpf_responsavel_empresa']);
            }
       
            (new GerenciaPost())->update($arrayPost, $this->tabela, "id", $id);

            header('location: ' . URL . $this->rota.'/editar/'.$id); exit;
        } 
        header('location: ' . URL . $this->rota); exit;   

    }

    public function desativar($id){
      
        if (isset($id)){
            if (isset($_POST['desativar'])) {
                
                (new ModelGenerico())->desativarItem($id, $this->tabela);
                header('location: ' . URL . $this->rota.'?desativado=true'); exit;
            }
        }
        header('location: ' . URL . $this->rota); exit;
    }
    

    public function ativar($id){
        if (isset($id)) {
            if (isset($_POST['ativar'])) {
                
                (new ModelGenerico())->ativarItem($id, $this->tabela);
                header('location: ' . URL . $this->rota.'?ativado=true'); exit;
            }
        }
        header('location: ' . URL . $this->rota); exit;
    }
}

