<?php

namespace Ops\Model;

use Ops\Core\Model;

use Firebase\JWT\JWT;

class GeraLinkHash extends Model
{
    public function link_redefinirSenha($id_usuario)
    {
        $data = date('Y-m-d', strtotime("+1 day"));

        $cript = array(
            'id_usuario' => $id_usuario,
            'data_expiracao' => $data
        );

        $hash = JWT::encode($cript, KEY_HASH);

        return $hash;
    }

    public function link_chat($id_orcamento, $id_distribuidor)
    {
        $cript = array(
            'id_orcamento' => $id_orcamento,
            'id_usuario' => $id_distribuidor
        );

        $hash = JWT::encode($cript, KEY_HASH);

        return $hash;
    }

    public function tokenAcessoNegociacao($id_usuario, $data, $id_empresa)
    {
        $cript = array(
            'DOLE' => 'dAlE',
            'oirausu_di' => $id_usuario,
            'atad' => $data,
            'aserpme_di' => $id_empresa,
            'dale' => 'dole'
        );

        $hash = JWT::encode($cript, KEY_HASH);

        return $hash;
    }
}
