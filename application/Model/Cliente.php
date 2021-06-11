<?php

namespace Ops\Model;

use Ops\Core\Model;
use stdClass;

class Cliente extends Model
{
    public function getClientes($qtd, $pagina, $filtros)
    {
        $filtros_query = "";
        $parameters = array();

        if (isset($filtros['ativo']) && $filtros['ativo'] != "") {
            if ($filtros['ativo'] == '0') {
                $ativo = true;
            } else {
                $ativo = false;
            }
            $filtros_query = $filtros_query . " AND c.ativo = :ativo";
            $parameters[':ativo'] = $filtros['ativo'];
        } else {
            $filtros_query = $filtros_query . " AND c.ativo = :ativo";
            $parameters[':ativo'] = true;
        }

        if (isset($filtros['buscar']) && $filtros['buscar'] != "") {
            $filtros_query = $filtros_query . " AND (ucase(c.nome) LIKE ucase(:buscar) OR ucase(c.cpf) LIKE ucase(:buscar))";
            $parameters[':buscar'] = '%' . $filtros['buscar'] . '%';
        }

        $offset = ($pagina - 1) * $qtd;

        $sql = "SELECT
                    c.*, cid.nome AS nome_cidade
                FROM
                    cliente c
                    LEFT JOIN cidade cid
                    ON cid.id = c.id_cidade
                
                WHERE TRUE
                    $filtros_query
                ORDER BY c.nome ASC
                LIMIT $qtd OFFSET $offset";

        $query = $this->db->prepare($sql);

        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getTiposCliente(){
        $arrayTipos = [];

        $tipo = new stdClass();
        $tipo->id = 1;
        $tipo->nome = "Pessoa Física";

        $arrayTipos[] = $tipo;
        
        $tipo = new stdClass();
        $tipo->id = 2;
        $tipo->nome = "Pessoa Jurídica";
        
        $arrayTipos[] = $tipo;

        return $arrayTipos;
    }
}