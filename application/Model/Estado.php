<?php

namespace Ops\Model;

use Ops\Core\Model;

class Estado extends Model
{

    public function getEstados()
    {
        $sql = "SELECT * FROM estado";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getCidadesByEstado($uf)
    {
        $sql = "SELECT * FROM cidade WHERE uf = :uf";
        $query = $this->db->prepare($sql);
        $parameters = array(':uf' => $uf);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getEstadoByUf($uf)
    {
        $sql = "SELECT * FROM estado WHERE uf = :uf";
        $query = $this->db->prepare($sql);
        $parameters = array(':uf' => $uf);
        $query->execute($parameters);

        return $query->fetch();
    }

    public function getEstadoByCidade($id_cidade)
    {
        $sql = "SELECT estado.id, estado.uf, cidade.nome as cidade FROM estado INNER JOIN cidade ON (estado.uf = cidade.uf) WHERE cidade.id = :id_cidade";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_cidade' => $id_cidade);
        $query->execute($parameters);

        return $query->fetch();
    }
}
