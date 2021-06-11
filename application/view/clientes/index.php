<?php 
    use Ops\libs\Util;
?>
<div class="content-wrapper">
    <section class="content container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title line-height-default">Clientes</h3>
                        <div class="pull-right">
                            <a href="<?= URL . $this->controller . '/adicionar/' ?>" class="btn btn-info">Adicionar <i class="fa fa-plus icone-fa-left"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="box-body ">
                            <div class="form-group">
                                <form action="<?= URL . $this->dir  ?>" method="GET">
                                    <div class="col-md-4">
                                        <label>Buscar:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                            <input type="text" class="form-control" placeholder="Buscar" name="buscar" value="<?= (isset($_GET['buscar']) ? $_GET['buscar'] : ''); ?>">
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
                                <th>CPF/CNPJ</th>
                                <th>Celular</th>
                                <th>UF / Cidade</th>
                                <th class="td-status">Status</th>
                                <th class="td-acoes">Ações</th>
                            </thead>
                            <tbody>
                                <?php if (COUNT($clientes) > 0) { ?>
                                    <?php foreach ($clientes as $cliente) { ?>
                                        <tr>
                                            <td class="text-center"><?= $cliente->id ?></td>
                                            <td><?= $cliente->nome ?></td>
                                            <td><?= (strlen($cliente->cpf_cnpj) <= 11) ? Util::maskCpf($cliente->cpf_cnpj) : Util::maskCnpj($cliente->cpf_cnpj); ?></td>
                                            <td><?= Util::maskTelefone($cliente->celular) ?></td>
                                            <td><?= $cliente->uf_estado ." / " . $cliente->nome_cidade;  ?></td>
                                            <?php if ($cliente->ativo == true) : ?>
                                                <td class="text-center">
                                                    <span class="label label-success">Ativo</span>
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <a class="btn-circle btn-primary" href="<?= URL . $this->controller . "/editar/" . $cliente->id ?>"><i class="fa fa-pencil"></i></a>
                                                        <a class="btn-circle btn-danger btn-desativar-cliente" id="<?= $cliente->id ?>"><i class="fa fa-times"></i></a>
                                                    </div>
                                                </td>
                                            <?php else : ?>
                                                <td class="text-center">
                                                    <span class="label label-danger">Inativo</span>
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <a class="btn-circle btn-primary" href="<?= URL . $this->controller . "/editar/" . $cliente->id ?>"><i class="fa fa-pencil"></i></a>
                                                        <a class="btn-circle btn-success btn-ativar-cliente" id="<?= $cliente->id ?>"><i class="fa fa-check"></i></a>
                                                    </div>
                                                </td>
                                            <?php endif ?>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="7">Nenhum cliente cadastrado.</td>
                                    </tr>
                                <?php } ?>

                                <div id="desativa-cliente" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Aviso!</h4>
                                            </div>
                                            <div class="modal-body">
                                                Deseja realmente desativar esta cliente?
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

                                <div id="ativa-cliente" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Aviso!</h4>
                                            </div>
                                            <div class="modal-body">
                                                Deseja realmente ativar esta cliente?
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