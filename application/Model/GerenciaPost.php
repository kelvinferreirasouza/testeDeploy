<?php


namespace Ops\Model;

use Ops\Core\Model;

class GerenciaPost extends Model
{

    public function insert($arrayPost, $tabela, $retorno = null, $minusculo = false, $id_empresa = false, $html = false)
    {
        if ($id_empresa == true) {
            $arrayPost['id_empresa'] = $_SESSION['gdplace']['id_empresa'];
        }

        foreach ($arrayPost as $key => $value) {
            $arrColuna[] = $key;
            $arrColunaPdo[] = ":" . $key;
            $value = trim($value);

            if (!$html) {
                $value = strip_tags($value);
            }

            if ($key == 'senha') {
                $arrValor[':' . $key] = $value;
            } else {
                $arrValor[':' . $key] = (!$minusculo) ? mb_strtoupper($value, 'UTF-8') : $value;
            }
        }

        $coluna = implode(",", $arrColuna);
        $pdo = implode(",", $arrColunaPdo);

        $sql = "INSERT INTO {$tabela} ({$coluna}) VALUES ({$pdo})";

        $query = $this->db->prepare($sql);
        $parameters = $arrValor;

        $query->execute($parameters);

        if ($retorno) {
            $id_veiculo = $this->db->lastInsertId();
            return $id_veiculo;
        }
    }

    public function update($arrayPost, $tabela, $where_col, $where_val, $minusculo = false, $id_empresa = false, $html = false)
    {
        if ($id_empresa == true) {
            $arrayPost['id_empresa'] = $_SESSION['gdplace']['id_empresa'];
        }

        foreach ($arrayPost as $key => $value) {
            $arrColuna[] = $key . " = " . ":" . $key;
            $value = trim($value);

            if (!$html) {
                $value = strip_tags($value);
            }

            if ($key == 'senha') {
                $arrValor[':' . $key] = $value;
            } else {
                $arrValor[':' . $key] = (!$minusculo) ? mb_strtoupper($value, 'UTF-8') : $value;
            }
        }

        $coluna = implode(",", $arrColuna);

        $sql = "UPDATE {$tabela} SET {$coluna} WHERE {$where_col} = :id";
        $query = $this->db->prepare($sql);
        $parameters = $arrValor;
        $parameters[':id'] = $where_val;

        $query->execute($parameters);
    }
}
