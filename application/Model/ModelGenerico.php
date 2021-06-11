<?php


namespace Ops\Model;

use Ops\Core\Model;

class ModelGenerico extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function paginacao()
    {
        if (isset($_GET['pagina'])) {
            $paginacao = $_GET['pagina'];
        } else {
            $paginacao = 1;
        }
        return $paginacao;
    }

    public function getItens($qtd, $pagina, $filtros, $tabela, $id_empresa = false)
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
            $filtros_query = $filtros_query . " AND ucase(nome) LIKE ucase(:nome)";
            $parameters[':nome'] = '%' . $filtros['nome'] . '%';
        }

        if ($id_empresa) {
            $filtros_query = $filtros_query . " AND id_empresa = " . $_SESSION['gdplace']['id_empresa'];
        }

        $offset = ($pagina - 1) * $qtd;

        $sql = "SELECT * FROM {$tabela} WHERE TRUE $filtros_query ORDER BY nome ASC LIMIT $qtd OFFSET $offset";
        $query = $this->db->prepare($sql);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getItemByID($id, $tabela)
    {
        $sql = "SELECT * FROM {$tabela} WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function desativarItem($id, $tabela)
    {
        $sql = "UPDATE {$tabela} SET ativo = FALSE WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);

        $query->execute($parameters);
    }

    public function desativarItemByCampoGenerico($valor, $tabela, $campo)
    {
        $sql = "UPDATE {$tabela} SET ativo = FALSE WHERE {$campo} = :valor";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor' => $valor);

        $query->execute($parameters);
    }

    public function deletarRegistroById($id, $tabela)
    {
        $sql = "DELETE FROM {$tabela} WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);

        $query->execute($parameters);
    }

    public function deletarCampoGenerico($valor, $tabela, $campo)
    {
        $sql = "DELETE FROM {$tabela} WHERE {$campo} = :valor";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor' => $valor);

        $query->execute($parameters);
    }

    public function ativarItem($id, $tabela)
    {
        $sql = "UPDATE {$tabela} SET ativo = TRUE WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);

        $query->execute($parameters);
    }

    public function getItemByNome($nome, $tabela)
    {

        $sql = "SELECT * FROM {$tabela} WHERE nome = :nome";
        $query = $this->db->prepare($sql);
        $parameters = array(':nome' => $nome);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getItemByCampoGenerico($valor, $tabela, $campo) //fetchAll
    {
        $sql = "SELECT * FROM {$tabela} WHERE {$campo} = :valor";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor' => $valor);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getItemByCampoGenericoAndItemAtivo($valor, $tabela, $campo) //fetchAll
    {
        $sql = "SELECT * FROM {$tabela} WHERE {$campo} = :valor AND ativo = 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor' => $valor);
        $query->execute($parameters);

        return $query->fetch();
    }


    public function getItemUicoByCampoGenerico($valor, $tabela, $campo) //fetch
    {

        $sql = "SELECT * FROM {$tabela} WHERE {$campo} = :valor";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor' => $valor);
        $query->execute($parameters);

        return $query->fetch();
    }

    public function getItemAtivoByCampoGenerico($valor, $tabela, $campo)
    {

        $sql = "SELECT * FROM {$tabela} WHERE {$campo} = :valor AND ativo = 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor' => $valor);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getItemAtivoByCampoGenericoOrdenacao($valor, $tabela, $campo, $order)
    {

        $sql = "SELECT * FROM {$tabela} WHERE {$campo} = :valor AND ativo = 1 ORDER BY {$order}";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor' => $valor);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getItemByCampoGenericoOrdenacao($valor, $tabela, $campo, $order)
    {

        $sql = "SELECT * FROM {$tabela} WHERE {$campo} = :valor ORDER BY {$order}";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor' => $valor);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getItemUnicoAtivoByCampoGenerico($valor, $tabela, $campo)
    {
        $sql = "SELECT * FROM {$tabela} WHERE {$campo} = :valor AND ativo = 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor' => $valor);
        $query->execute($parameters);

        return $query->fetch();
    }

    public function getAllItens($tabela)
    {
        $sql = "SELECT * FROM {$tabela} WHERE ativo = 1";
        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getAllItensSemAtivo($tabela)
    {
        $sql = "SELECT * FROM {$tabela}";
        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getAllItensReturnArrayAssoc($tabela)
    {
        $sql = "SELECT * FROM {$tabela} WHERE ativo = 1";
        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllItensOrdenados($tabela)
    {
        $sql = "SELECT * FROM {$tabela} WHERE ativo = 1 ORDER BY nome ASC";
        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getItemByTresParametros($tabela, $coluna_1, $valor_1, $coluna_2, $valor_2, $coluna_3, $valor_3)
    {
        $sql = "SELECT * FROM 
                    {$tabela} 
                WHERE 
                    {$coluna_1} = :valor_1 AND 
                    {$coluna_2} = :valor_2 AND 
                    {$coluna_3} = :valor_3";
        $query = $this->db->prepare($sql);
        $parameters = array(':valor_1' => $valor_1, ':valor_2' => $valor_2, ':valor_3' => $valor_3);
        $query->execute($parameters);

        return $query->fetch();
    }

    public function getItemByUsersAndDates($id, $tabela)
    {
        $sql = "SELECT *, 
                (SELECT us.nome FROM usuarios us WHERE us.id_usuario = x.id_usuario_cadastro)AS usuario_cadastro,
                (SELECT us.nome FROM usuarios us WHERE us.id_usuario = x.id_usuario_atualizacao)AS usuario_atualizacao,
                (SELECT DATE_FORMAT(x.data_atualizacao, '%d/%m/%Y %H:%i'))AS data_atualizado,
                (SELECT DATE_FORMAT(x.data_cadastro, '%d/%m/%Y %H:%i'))AS data_cadastrado
                FROM {$tabela} x 
                WHERE x.id = :id";

        $query = $this->db->prepare($sql);
        $param = array(':id' => $id);
        $query->execute($param);

        return $query->fetch();
    }
}
