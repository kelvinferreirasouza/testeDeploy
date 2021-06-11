<div class="content-wrapper">
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cadastrar Usuário</h3>
                    </div>
                    <form role="form" action="<?= URL ?>usuarios/cadastrarUsuario" method="POST" class="frmChecaUsuario">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nome">Nome <span class="obrigatorio">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group box-email">
                                        <label for="email">E-mail <span class="obrigatorio">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 col-lg-4">
                                    <label for="perfil">Tipo <span class="obrigatorio">*</span></label>
                                    <select name="id_perfil" class="form-control">
                                        <?php foreach ($usuarios_perfil as $perfil) { ?>
                                            <option value="<?= $perfil->id; ?>"><?= $perfil->nome; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group box-senha">
                                        <label for="senha">Senha <span class="obrigatorio">*</span></label>
                                        <input type="password" class="form-control" id="senha" name="senha" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group box-senha">
                                        <label for="senha">Confirmação de Senha <span class="obrigatorio">*</span></label>
                                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 col-lg-4">
                                    <label for="nome">Telefone</label>
                                    <input autocomplete="off" type="text" class="form-control" id="telefone_residencial" name="telefone" data-inputmask="'mask': '(99) 9999-9999'" data-mask>
                                </div>

                                <div class="form-group col-md-4 col-lg-4">
                                    <label for="nome">Celular</label>
                                    <input autocomplete="off" type="text" class="form-control" id="celular1" name="celular" data-inputmask="'mask': '(99) 99999-9999'" data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="button" class="btn btn-danger" onclick='location.href = "<?= URL . $this->dir; ?>"'>Voltar <i class="fa fa-arrow-left icone-fa-left"></i> </button>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-block btn-primary" name="cadastrar">Cadastrar <i class="fa fa-floppy-o icone-fa-left"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>