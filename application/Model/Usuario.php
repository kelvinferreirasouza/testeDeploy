<?php

namespace Ops\Model;

use Ops\Core\Model;

class Usuario extends Model
{
    public function checaSessao()
    {
        session_start();
        if (isset($_SESSION['ops']['id']) == false) {
            header('location: ' . URL . 'login/index');
            exit;
        }
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

    public function getUsuarioByEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getUsuarioById($id_usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_usuario' => $id_usuario);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getUsuarios($qtd, $pagina, $filtros)
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

        if (isset($filtros['email']) && $filtros['email'] != "") {
            $filtros_query = $filtros_query . " AND ucase(email) LIKE ucase(:email)";
            $parameters[':email'] = '%' . $filtros['email'] . '%';
        }

        $offset = ($pagina - 1) * $qtd;

        $sql = "SELECT
                    us.*, up.nome as tipo_perfil
                FROM
                    usuarios us, usuario_perfil up
                WHERE
                    us.id_perfil = up.id
                AND
                    TRUE $filtros_query
                ORDER BY
                    nome ASC
                LIMIT $qtd OFFSET $offset";

        $query = $this->db->prepare($sql);

        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function insertUsuario($dados)
    {
        $arrayInsert = [];

        $arrayInsert['nome'] = $dados['nome'];
        $arrayInsert['email'] = $dados['email'];
        $arrayInsert['senha'] = md5($dados['senha']);
        $arrayInsert['telefone'] = preg_replace('/[^0-9]{1,}/', '', $dados['telefone']);
        $arrayInsert['celular'] = preg_replace('/[^0-9]{1,}/', '', $dados['celular']);
        $arrayInsert['id_perfil'] = $dados['id_perfil'];
        $arrayInsert['ativo'] = 1;

        (new GerenciaPost())->insert($arrayInsert, 'usuarios');
    }

    public function updateUsuario($dados)
    {
        $arrayUpdate = [];

        $arrayUpdate['nome'] = $dados['nome'];
        $arrayUpdate['email'] = $dados['email'];
        $arrayUpdate['senha'] = md5($dados['senha']);
        $arrayUpdate['telefone'] = preg_replace('/[^0-9]{1,}/', '', $dados['telefone']);
        $arrayUpdate['celular'] = preg_replace('/[^0-9]{1,}/', '', $dados['celular']);
        $arrayUpdate['id_perfil'] = $dados['id_perfil'];
        $arrayUpdate['nivel'] = $dados['nivel'];
        $arrayUpdate['ativo'] = $dados['ativo'];

        (new GerenciaPost())->update($arrayUpdate, 'usuarios', 'id_usuario', $dados['id_usuario']);
    }

    public function desativaUsuario($id_usuario)
    {
        $sql = "UPDATE usuarios SET ativo = FALSE WHERE id_usuario = :id_usuario";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_usuario' => $id_usuario);

        $query->execute($parameters);
    }

    public function ativaUsuario($id_usuario)
    {
        $sql = "UPDATE usuarios SET ativo = TRUE WHERE id_usuario = :id_usuario";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_usuario' => $id_usuario);

        $query->execute($parameters);
    }
}
