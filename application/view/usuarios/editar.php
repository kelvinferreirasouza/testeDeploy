<div class="content-wrapper">
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Usuário</h3>
                    </div>
                    <form role="form" action="<?= URL . $this->dir . "/updateUsuario/$id_usuario" ?>" method="POST" class="frmChecaUsuario">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nome">Nome <span class="obrigatorio">*</span></label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?= $usuario->nome ?>" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="box-email">
                                        <label for="email">E-mail <span class="obrigatorio">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $usuario->email ?>" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 col-lg-4">
                                    <label for="perfil">Tipo <span class="obrigatorio">*</span></label>
                                    <select name="id_perfil" class="form-control" required>
                                        <?php foreach ($usuarios_perfil as $perfil) { ?>
                                            <option value="<?= $perfil->id; ?>" <?= $perfil->id == $usuario->id_perfil ? 'selected' : '' ?>><?= $perfil->nome; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="box-senha">
                                        <label for="senha">Senha</label>
                                        <input type="password" class="form-control" id="senha" name="senha">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="box-senha">
                                        <label for="senha">Confirmação de Senha</label>
                                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha">
                                    </div>
                                </div>

                                <div class="form-group col-md-4 col-lg-4">
                                    <label for="nome">Telefone</label>
                                    <input type="text" autocomplete="off" class="form-control" id="telefone_residencial" value="<?= $usuario->telefone ?>" name="telefone" data-inputmask="'mask': '(99) 9999-9999'" data-mask>
                                </div>

                                <div class="form-group col-md-4 col-lg-4">
                                    <label for="nome">Celular</label>
                                    <input type="text" autocomplete="off" class="form-control" id="celular1" value="<?= $usuario->celular ?>" name="celular" data-inputmask="'mask': '(99) 99999-9999'" data-mask>
                                </div>

                                <div class="form-group col-md-4 col-lg-4">
                                    <label for="ativo">Status</label>
                                    <select name="ativo" class="form-control">
                                        <?php if ($usuario->ativo == true) : ?>
                                            <option value="1" selected="selected">Ativo</option>
                                            <option value="0">Inativo</option>
                                        <?php else : ?>
                                            <option value="0" selected="selected">Inativo</option>
                                            <option value="1">Ativo</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="button" class="btn btn-danger" onclick='location.href = "<?= URL . $this->rota; ?>"'>Voltar <i class="fa fa-arrow-left icone-fa-left"></i></button>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-block btn-primary" name="editar">Alterar <i class="fa fa-check icone-fa-left"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>