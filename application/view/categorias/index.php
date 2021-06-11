<!-- ARQUIVOS NECESSÁRIOS PARA O TOAST FUNCIONAR! -->
<link rel="stylesheet" href="<?= URL . "css/" . VERSAO . "/toastr.min.css" ?>">
<script src="<?= URL . "js/" . VERSAO . "/jquery.min.js" ?>"></script>
<script src="<?= URL . "js/" . VERSAO . "/toastr.min.js" ?>"></script>

<div class="content-wrapper">
    <section class="content container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title line-height-default">Categorias</h3>
                        <div class="pull-right">
                            <a href="<?= URL . 'categorias/adicionar/' ?>" class="btn btn-info">Adicionar <i class="fa fa-plus icone-fa-left"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="box-body ">
                            <div class="form-group">
                                <form action="<?= URL . $this->dir  ?>" method="GET">
                                    <div class="col-md-4">
                                        <label>Nome da Categoria:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                                            <input type="text" class="form-control" placeholder="Nome" name="nome" value="<?= (isset($_GET['nome']) ? $_GET['nome'] : ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Status:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                            <select class="form-control" name="ativo">
                                                <option value="1" <?= (isset($_GET['ativo']) && $_GET['ativo'] == '1' ? "selected='selected'" : ''); ?>>Ativo</option>
                                                <option value="0" <?= (isset($_GET['ativo']) && $_GET['ativo'] == '0' ? "selected='selected'" : ''); ?>>Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-primary btn-pesquisar-label" name="filtrar">Pesquisar <i class="fa fa-search icone-fa-left"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th class="td-id">Cód.</th>
                                <th>Nome</th>
                                <th class="td-status">Status</th>
                                <th class="td-acoes">Ações</th>
                            </thead>
                            <tbody>
                                <?php if (COUNT($categorias) > 0) { ?>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <tr>
                                            <td class="text-center"><?= $categoria->id ?></td>
                                            <td><?= $categoria->nome ?></td>
                                            <?php if ($categoria->ativo == true) : ?>
                                                <td class="text-center">
                                                    <span class="label label-success">Ativo</span>
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <a class="btn-circle btn-primary" href="<?= URL . "categorias/editar/$categoria->id" ?>"><i class="fa fa-pencil"></i></a>
                                                        <a class="btn-circle btn-danger btn-desativar-categoria" id="<?= $categoria->id ?>"><i class="fa fa-times"></i></a>
                                                    </div>
                                                </td>
                                            <?php else : ?>
                                                <td class="text-center">
                                                    <span class="label label-danger">Inativo</span>
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <a class="btn-circle btn-primary" href="<?= URL . "categorias/editar/$categoria->id" ?>"><i class="fa fa-pencil"></i></a>
                                                        <a class="btn-circle btn-success btn-ativar-categoria" id="<?= $categoria->id ?>"><i class="fa fa-check"></i></a>
                                                    </div>
                                                </td>
                                            <?php endif ?>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="4">Nenhuma categoria cadastrada.</td>
                                    </tr>
                                <?php } ?>

                                <div id="desativa-categoria" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Aviso!</h4>
                                            </div>
                                            <div class="modal-body">
                                                Deseja realmente desativar esta categoria?
                                            </div>
                                            <form method="POST" class="form-desativar">
                                                <div class="modal-footer">
                                                    <div class="pull-left">
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar <i class="fa fa-times icone-fa-left"></i></button>
                                                    </div>
                                                    <button type="submit" class="btn btn-danger" name="desativar">Desativar <i class="fa fa-check icone-fa-left"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div id="ativa-categoria" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Aviso!</h4>
                                            </div>
                                            <div class="modal-body">
                                                Deseja realmente ativar esta categoria?
                                            </div>
                                            <form method="POST" class="form-ativar">
                                                <div class="modal-footer">
                                                    <div class="pull-left">
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar <i class="fa fa-times icone-fa-left"></i></button>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" name="ativar">Ativar <i class="fa fa-check icone-fa-left"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            <?php if (($paginacao - 1) >= 1) : ?>
                                <li><a href="<?= preg_replace('/(&pagina=[0-9]{1,}){1}/', '', $_SERVER['REQUEST_URI']) . '&pagina=' . ($paginacao - 1) ?>">&laquo; Anterior</a></li>
                            <?php endif ?>
                            <?php if (count($paginacao_proximo) > 0) : ?>
                                <li><a href="<?= preg_replace('/(&pagina=[0-9]{1,}){1}/', '', $_SERVER['REQUEST_URI']) . '&pagina=' . ($paginacao + 1) ?>">Próxima &raquo;</a></li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if (isset($_GET['desativado']) && $_GET['desativado'] == 'true') { ?>
    <script>
        toastSucessMessage('Categoria desativada com sucesso!');
    </script>
<?php } ?>

<?php if (isset($_GET['ativado']) && $_GET['ativado'] == 'true') { ?>
    <script>
        toastSucessMessage('Categoria ativada com sucesso!');
    </script>
<?php } ?>