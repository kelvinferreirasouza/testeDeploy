<?php

namespace Ops\Model;

use Ops\Core\Model;
use Ops\libs\Util;

class Franquia extends Model
{
    public function getFranquias($qtd, $pagina, $filtros)
    {
        $filtros_query = "";
        $parameters = array();

        if (isset($filtros['ativo']) && $filtros['ativo'] != "") {
            $filtros_query .= " AND ativo = :ativo";
            $parameters[':ativo'] = $filtros['ativo'];
        } else {
            $filtros_query .= " AND ativo = 1";
        }

        if (isset($filtros['nome']) && $filtros['nome'] != "") {
            $filtros_query .= " AND ucase(razao_social) LIKE ucase('%{$filtros['nome']}%')";
            $filtros_query .= " AND ucase(nome_fantasia) LIKE ucase('%{$filtros['nome']}%')";
        }

        if (isset($filtros['cnpj']) && $filtros['cnpj'] != "") {
            $filtros_query .= " AND cnpj = :cnpj";
            $parameters[':cnpj'] = Util::formataLimpaString($filtros['cnpj']);
        }

        $offset = ($pagina - 1) * $qtd;

        $sql = "SELECT
                    *
                FROM
                    franquia
                WHERE
                    TRUE $filtros_query
                ORDER BY
                    razao_social ASC
                LIMIT $qtd OFFSET $offset";

        $query = $this->db->prepare($sql);

        $query->execute($parameters);

        return $query->fetchAll();
    }
}
