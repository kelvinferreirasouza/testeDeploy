<?php

namespace Ops\Model;

use Ops\Core\Model;
use WideImage\WideImage;
use Ops\libs\FuncaoArray;

class Categoria extends Model
{
    public function getCategorias($qtd, $pagina, $filtros = false)
    {
        $filtros_query = '';
        $parameters = array();

        if (isset($filtros['ativo']) && $filtros['ativo'] != '') {
            $filtros_query .= " AND c.ativo = :ativo";
            $parameters[':ativo'] = $filtros['ativo'];
        } else {
            $filtros_query .= " AND c.ativo = 1";
        }

        if (isset($filtros['nome']) && $filtros['nome'] != '') {

            $filtros['nome'] = trim(strtoupper($filtros['nome']));

            $filtros_query .= " AND c.nome LIKE '%{$filtros['nome']}%'";
        }

        $offset = ($pagina - 1) * $qtd;

        $sql = " SELECT
                        c.*
                    FROM
                        categoria c
                    WHERE
                        TRUE $filtros_query
                    LIMIT
                        $qtd OFFSET $offset";

        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function insertCategoria($nome)
    {
        if (isset($nome)) {
            $arrayInsert = [];

            $arrayInsert['nome'] = $_POST['nome'];
            $arrayInsert['id_usuario_criacao'] = $_SESSION['ops']['id'];

            $id_categoria = (new GerenciaPost())->insert($arrayInsert, 'categoria', $retorno = true, $min = true);

            return $id_categoria;
        }
    }

    public function uploadImagem($imagem)
    {
        $formatosAceitos = array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',

        );

        $newname = uniqid(time());
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $newname = preg_replace("/[^0-9a-zA-Z]{1,}/", "-", $newname);
        $imageExtension = array_search($finfo->file($imagem['tmp_name']), $formatosAceitos, true);
        $folder = 'img/imagem_categoria/';

        if ($imagem['type'] == 'image/jpeg') {
            $miniNome = $newname . 'MD.jpg';
            $qualidade = 100;
        } elseif ($imagem['type'] == 'image/png') {
            $miniNome = $newname . 'MD.png';
            $qualidade = 9;
        }

        $nova = WideImage::load($imagem['tmp_name']);

        $white = $nova->allocateColor(255, 255, 255);

        $nova = $nova->resize(600, 400);

        $nova = $nova->resizeCanvas(600, 400, 'center', 'center', $white);

        $nova->saveToFile($folder . $miniNome, $qualidade);

        if ($imageExtension === false) {
            return array('error' => true, 'reason' => 'Extensão da imagem não aceito.');
        }

        if ($imagem['size'] > 10000000) {
            return array('error' => true, 'reason' => 'Tamanho da imagem superior a 10mb.');
        }

        if (file_exists($folder . $newname . '.' . $imageExtension)) {
            return array('error' => true, 'reason' => 'Já existe um arquivo com este nome.');
        }


        if (!move_uploaded_file($imagem['tmp_name'], $folder . $newname . '.' . $imageExtension)) {
            return array('error' => true, 'reason' => 'Erro ao mover o arquivo para a pasta destino.');
        }

        return array('error' => false, 'filename' => $newname . '.' . $imageExtension, 'filename_md' => $miniNome);
    }

    public function salvaImagem($id_categoria, $nome, $nome_md)
    {
        $arrayInsert = [];
        $arrayInsert['id_categoria'] = $id_categoria;
        $arrayInsert['imagem'] = $nome;
        $arrayInsert['imagem_md'] = $nome_md;

        (new GerenciaPost())->insert($arrayInsert, 'categoria_imagem', $ret = false, $min = true);
    }

    public function updateCategoriaById($id_categoria, $post, $imgs = false)
    {
        if (isset($id_categoria) && isset($post)) {
            $arrayUpdate = [];

            $arrayUpdate['nome'] = $_POST['nome'];
            $arrayUpdate['id_usuario_atualizacao'] = $_SESSION['ops']['id'];
            $arrayUpdate['data_atualizacao'] = date('Y-m-d H:i:s');

            (new GerenciaPost())->update($arrayUpdate, 'categoria', 'id', $id_categoria, $min = true);

            if ($imgs) {
                $a = new FuncaoArray();
                $imagens = $a->reArrayFiles($imgs['imagem']);  //Arruma os índices do array $_FILES

                foreach ($imagens as $imagem) {

                    if ($imagem['type'] == 'image/jpeg' || $imagem['type'] == 'image/png') {

                        $upload = $this->uploadImagem($imagem);

                        if (!$upload['error']) {
                            $this->salvaImagem($id_categoria, $upload['filename'], $upload['filename_md']);
                        } else {
                            header('location: ' . URL . 'categorias' . '?atualizado=false');
                            exit;
                        }
                    } else {
                        header('location: ' . URL . 'categorias' . '?atualizado=false');
                        exit;
                    }
                }
            } else {
                header('location: ' . URL . 'categorias' . '/editar/' . $id_categoria . '?atualizado=true');
                exit;
            }
        }
    }

    public function deletarImagem($id_imagem, $nome_arquivo)
    {
        $img = explode(".", $nome_arquivo);
        $thumb = $img[0] . "MD.png";

        @unlink("../public/img/imagem_categoria/" . $nome_arquivo);
        @unlink("../public/img/imagem_categoria/" . $thumb);

        $sql = "DELETE FROM categoria_imagem WHERE id = :id_imagem";
        $query = $this->db->prepare($sql);
        $parameters = array(':id_imagem' => $id_imagem);

        $query->execute($parameters);
    }
}
