<?php if (isset($categoria)) { ?>
    <script src="<?= URL . "js/" . VERSAO . "/jquery.min.js" ?>"></script>
    <script src="<?= URL . "js/" . VERSAO . "/toastr.min.js" ?>"></script>
<?php } ?>

<div class="content-wrapper">
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form role="form" action="<?= URL . $this->dir . (isset($categoria) ? '/editarCategoria/' . $categoria->id : '/adicionarCategoria') ?>" method="POST" enctype="multipart/form-data" class="frmChecaUsuario">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= isset($categoria) ? '<strong>Editar</strong>' : '<strong>Cadastrar</strong>' ?> Categoria</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="nome">Nome: <span class="obrigatorio">*</span></label>
                                                <input type="text" class="form-control" id="nome" name="nome" value="<?= isset($categoria->nome) ? $categoria->nome : '' ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nome">Imagem:</label>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="row">
                                                        <label class="customFileInput clearfix">
                                                            <div class="button btn btn-success">Escolher Arquivo <i class="fa fa-file-image-o icone-fa-left"></i></div>
                                                            <input type=file id="imagem" name="imagem[]" multiple onchange="showFileName(this)">
                                                            <div class="fileName"></div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= URL . $this->dir; ?>" class="btn btn-danger">Voltar <i class="fa fa-arrow-left icone-fa-left"></i> </a>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-block btn-primary" name="cadastrar"><?= isset($categoria) ? 'Atualizar <i class="fa fa-check icone-fa-left"></i>' : 'Cadastrar <i class="fa fa-floppy-o icone-fa-left"></i>' ?> </button>
                            </div>
                        </div>
                    </div>
                </form>

                <?php if (isset($categoria_imagens) && !empty($categoria_imagens)) { ?>
                    <form role="form" action="<?= URL . $this->dir . "/deletarImagem/" ?>" method="POST" class="frmChecaUsuario form-deletar-imgs">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <strong>Imagens</strong> da Categoria
                                    <small class="subtitle">Listagem das imagens da categoria, para excluí-las, basta seleciona-lás.</small>
                                </h3>
                                <div class="pull-right">
                                    <button type="button" name="cadastrar" class="btn btn-warning" onclick="verificaImagensExclusao(event)">Excluir Imagens <i class="fa fa-times icone-fa-left"></i></button>
                                    <input type="hidden" name="id_categoria" value="<?= $categoria->id; ?>" />
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="position-relative">
                                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <?php foreach ($categoria_imagens as $categoria_imagem) : ?>
                                            <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12">
                                                <div class="galeria-veiculo text-center">
                                                    <a class="fancy a-galeria" rel="group1" href="<?= URL . 'img/imagem_categoria/' . $categoria_imagem->imagem ?>">
                                                        <img class="img-responsive auto" alt="Imagem da Categoria" src="<?= URL . 'img/imagem_categoria/' . $categoria_imagem->imagem_md ?>" />
                                                    </a>

                                                    <label class="label-checkbox">
                                                        <input type="checkbox" class="ipt-sel pull-left chk_img cursor-pointer" name="imagem[]" id="<?= "imagem{$categoria_imagem->id}"; ?>" value="<?= $categoria_imagem->id . "&" . $categoria_imagem->imagem; ?>" />
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } else if (isset($categoria)) { ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Imagens da Categoria</h3>
                        </div>
                        <div class="box-body">
                            <h5 class="text-center">Nenhuma imagem cadastrada.</h5>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>

<?php if (isset($_GET['cadastrado']) && $_GET['cadastrado'] == 'true') { ?>
    <script>
        toastSucessMessage('Categoria Cadastrada com sucesso!');
    </script>
<?php } ?>

<?php if (isset($_GET['atualizado']) && $_GET['atualizado'] == 'true') { ?>
    <script>
        toastSucessMessage('Categoria Atualizada com sucesso!');
    </script>
<?php } ?>

<?php if (isset($_GET['imgExcluida']) && $_GET['imgExcluida'] == 'true') { ?>
    <script>
        toastSucessMessage('Imagens Excluídas com Sucesso!!');
    </script>
<?php } ?>