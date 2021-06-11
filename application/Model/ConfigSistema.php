<?php


namespace Ops\Model;

use Ops\Core\Model;

class ConfigSistema extends Model
{

    public function getConfigs()
    {
        $sql = "SELECT * FROM configuracao_sistema WHERE id = 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => 1);

        $query->execute($parameters);

        return $query->fetch();
    }

    public static function isEnderecoLocal()
    {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );

        if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getIpUser()
    {
        $ipaddress = '';

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        if ($ipaddress == '::1') { // LOCALHOST
            $ipaddress = '127.0.0.1';
        }

        return $ipaddress;
    }

    public function updateConfiguracoesGerais($dados)
    {
        $arrayEmpresa = [];

        $arrayEmpresa['cnpj'] = $dados['cnpj'];
        $arrayEmpresa['ie'] = $dados['ie'];
        $arrayEmpresa['razao_social'] = $dados['razao_social'];
        $arrayEmpresa['nome_fantasia'] = $dados['nome_fantasia'];
        $arrayEmpresa['email'] = $dados['email'];
        $arrayEmpresa['id_estado'] = $dados['id_estado'];
        $arrayEmpresa['id_cidade'] = $dados['id_cidade'];
        $arrayEmpresa['cep'] = $dados['cep'];
        $arrayEmpresa['endereco'] = $dados['endereco'];
        $arrayEmpresa['numero_endereco'] = $dados['numero_endereco'];
        $arrayEmpresa['bairro'] = $dados['bairro'];
        $arrayEmpresa['telefone'] = $dados['telefone'];
        $arrayEmpresa['celular'] = $dados['celular'];

        (new GerenciaPost())->update($arrayEmpresa, 'dados_empresa', 'id', 1);

        $arrayConfigSistema = [];
        $arrayConfigSistema['titulo'] = $dados['titulo'];
        $arrayConfigSistema['rodape'] = $dados['rodape'];

        (new GerenciaPost())->update($arrayConfigSistema, 'configuracao_sistema', 'id', 1, true);
    }
}
