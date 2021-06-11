<?php

namespace Ops\Model;

use Ops\Core\Model;

class Plataforma extends Model
{
    public function paginacao()
    {
        if (isset($_GET['pagina'])) {
            $paginacao = $_GET['pagina'];
        } else {
            $paginacao = 1;
        }
        return $paginacao;
    }


    public function getPlataformaById($id_plataforma)
    {
        $sql = "SELECT * FROM plataformas WHERE id_plataforma = :id_plataforma";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_plataforma' => $id_plataforma);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getPlataformaByNome($nome)
    {
        $sql = "SELECT * FROM plataformas WHERE ucase(nome_plataforma) LIKE ucase(:nome)";
        $query = $this->db->prepare($sql);
        $parameters = array(':nome' => $nome);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getPlataformaByEmail($email)
    {
        $sql = "SELECT * FROM plataformas WHERE email = :email";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getPlataformasAtivas($qtd, $pagina, $filtros)
    {
        $filtros_query = "";
        $parameters = array();

        if (isset($filtros['ativo']) && $filtros['ativo'] != "") {
            if ($filtros['ativo'] == '0') {
                $ativo = true;
            } else {
                $ativo = false;
            }
            $filtros_query = $filtros_query . " AND ativo = :ativo";
            $parameters[':ativo'] = $filtros['ativo'];
        } else {
            $filtros_query = $filtros_query . " AND ativo = :ativo";
            $parameters[':ativo'] = true;
        }

        if (isset($filtros['nome']) && $filtros['nome'] != "") {
            $filtros_query = $filtros_query . " AND ucase(nome_plataforma) LIKE ucase(:nome)";
            $parameters[':nome'] = '%' . $filtros['nome'] . '%';
        }

        if (isset($filtros['email']) && $filtros['email'] != "") {
            $filtros_query = $filtros_query . " AND email = :email";
            $parameters[':email'] = $filtros['email'];
        }

        if (isset($filtros['razao_social']) && $filtros['razao_social'] != "") {
            $filtros_query = $filtros_query . " AND ucase(razao_social) LIKE ucase(:razao_social)";
            $parameters[':razao_social'] = '%' . $filtros['razao_social'] . '%';
        }

        $offset = ($pagina - 1) * $qtd;
        $sql = "SELECT * FROM plataformas WHERE true $filtros_query ORDER BY nome_plataforma ASC LIMIT $qtd OFFSET $offset";

        $query = $this->db->prepare($sql);

        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function adicionaPlataforma($nome_plataforma, $razao_social, $nome_fantasia, $insc_estadual, $cpf_cnpj, $logradouro, $bairro, $id_cidade, $id_estado, $complemento, $fone01, $cep, $fone02, $email, $senha, $ativo, $valor_cartao_ativo, $valor_cartao_adesao)
    {
        $sql = "INSERT INTO plataformas (nome_plataforma, razao_social, nome_fantasia, insc_estadual, cpf_cnpj, logradouro, bairro, id_cidade, id_estado, complemento, fone01, cep, fone02, email, senha, ativo, valor_cartao_ativo, valor_cartao_adesao) VALUES (:nome_plataforma, :razao_social, :nome_fantasia, :insc_estadual, :cpf_cnpj, :logradouro, :bairro, :id_cidade, :id_estado, :complemento, :fone01, :cep, :fone02, :email, :senha, :ativo, :valor_cartao_ativo, :valor_cartao_adesao)";
        $query = $this->db->prepare($sql);
        $parameters = array(':nome_plataforma' => $nome_plataforma, ':razao_social' => $razao_social, ':nome_fantasia' => $nome_fantasia, ':insc_estadual' => $insc_estadual, ':cpf_cnpj' => $cpf_cnpj, ':logradouro' => $logradouro, ':bairro' => $bairro, ':id_cidade' => $id_cidade, ':id_estado' => $id_estado, ':complemento' => $complemento, ':fone01' => $fone01, ':cep' => $cep, ':fone02' => $fone02, ':email' => $email, ':senha' => $senha, ':ativo' => $ativo, ':valor_cartao_ativo' => $valor_cartao_ativo, ':valor_cartao_adesao' => $valor_cartao_adesao);

        $query->execute($parameters);
    }

    public function updatePlataforma($id_plataforma, $nome_plataforma, $razao_social, $nome_fantasia, $insc_estadual, $cpf_cnpj, $logradouro, $bairro, $id_cidade, $id_estado, $complemento, $fone01, $cep, $fone02, $ativo, $valor_cartao_ativo, $valor_cartao_adesao)
    {
        $sql = "UPDATE plataformas SET nome_plataforma = :nome_plataforma, razao_social = :razao_social, nome_fantasia = :nome_fantasia, insc_estadual = :insc_estadual, cpf_cnpj = :cpf_cnpj, logradouro = :logradouro, bairro = :bairro, id_cidade = :id_cidade, id_estado = :id_estado, complemento = :complemento, fone01 = :fone01, cep = :cep, fone02 = :fone02, ativo = :ativo, valor_cartao_ativo = :valor_cartao_ativo, valor_cartao_adesao = :valor_cartao_adesao WHERE id_plataforma = :id_plataforma";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_plataforma' => $id_plataforma, ':nome_plataforma' => $nome_plataforma, ':razao_social' => $razao_social, ':nome_fantasia' => $nome_fantasia, ':insc_estadual' => $insc_estadual, ':cpf_cnpj' => $cpf_cnpj, ':logradouro' => $logradouro, ':bairro' => $bairro, ':id_cidade' => $id_cidade, ':id_estado' => $id_estado, ':complemento' => $complemento, ':fone01' => $fone01, ':cep' => $cep, ':fone02' => $fone02, ':ativo' => $ativo, ':valor_cartao_ativo' => $valor_cartao_ativo, ':valor_cartao_adesao' => $valor_cartao_adesao);

        $query->execute($parameters);
    }

    public function updatePerfil($id_plataforma, $email, $senha)
    {
        $sql = "UPDATE plataformas SET email = :email, senha = :senha WHERE id_plataforma = :id_plataforma";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_plataforma' => $id_plataforma, ':email' => $email, ':senha' => $senha);

        $query->execute($parameters);
    }

    public function desativaPlataforma($id_plataforma)
    {
        $sql = "UPDATE plataformas SET ativo = FALSE WHERE id_plataforma = :id_plataforma";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_plataforma' => $id_plataforma);

        $query->execute($parameters);
    }

    public function ativaPlataforma($id_plataforma)
    {
        $sql = "UPDATE plataformas SET ativo = TRUE WHERE id_plataforma = :id_plataforma";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_plataforma' => $id_plataforma);

        $query->execute($parameters);
    }

    public function getPlataformas()
    {
        $sql = "SELECT * FROM plataformas WHERE ativo = TRUE ORDER BY nome_plataforma ASC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getPlataformaByVendedorId($id_vendedor)
    {
        $sql = "SELECT plataformas.nome_plataforma FROM plataformas INNER JOIN vendedores ON (plataformas.id_plataforma = vendedores.id_plataforma) WHERE vendedores.id_vendedor = :id_vendedor";
        $query = $this->db->prepare($sql);
        $query->execute(
            [
                ':id_vendedor' => $id_vendedor
            ]
        );

        return $query->fetch();
    }
}
