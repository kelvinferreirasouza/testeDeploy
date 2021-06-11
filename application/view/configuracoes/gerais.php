<?php

use Ops\libs\Util;

?>

<!-- ARQUIVOS NECESSÁRIOS PARA O TOAST FUNCIONAR! -->
<link rel="stylesheet" href="<?= URL . "css/" . VERSAO . "/toastr.min.css" ?>">
<script src="<?= URL . "js/" . VERSAO . "/jquery.min.js" ?>"></script>
<script src="<?= URL . "js/" . VERSAO . "/toastr.min.js" ?>"></script>

<div class="content-wrapper">
    <section class="content container-fluid">
        <form role="form" action="<?= URL ?>configuracoes/updateConfiguracoesGerais" method="POST">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Configurações do Sistema</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="titulo">Título do Sistema</label>
                            <input type="text" name="titulo" class="form-control" id="titulo" value="<?= $config->titulo ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="rodape">Rodapé do Sistema</label>
                            <input type="text" class="form-control" d="rodape" name="rodape" value="<?= $config->rodape ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Dados da Empresa</h4>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-md-2 col-lg-2">
                                    <label>CNPJ</label><span class="obrigatorio"> *</span>
                                    <input class="form-control" type="text" name="cnpj" id="cnpj" value="<?= isset($config_empresa->cnpj) ? $config_empresa->cnpj : "" ?>" cnpj_mask required placeholder="ex: 99.999.999/9999-99" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label>IE</label><span class="obrigatorio"> *</span>
                                    <a aria-hidden="true" class="btn-isento pull-right cursor-pointer">Isento</a>
                                    <input class="form-control" type="text" name="ie" id="ie" value="<?= isset($config_empresa->ie) ? $config_empresa->ie : "" ?>" required autocomplete="off">
                                </div>
                                <div class="form-group col-md-4 col-lg-4">
                                    <label>Razão Social</label><span class="obrigatorio"> *</span>
                                    <input class="form-control" type="text" name="razao_social" id="razao_social" value="<?= isset($config_empresa->razao_social) ? $config_empresa->razao_social : "" ?>" required autocomplete="off">
                                </div>
                                <div class="form-group col-md-4 col-lg-4">
                                    <label>Nome Fantasia</label><span class="obrigatorio"> *</span>
                                    <input class="form-control" type="text" name="nome_fantasia" id="nome_fantasia" value="<?= isset($config_empresa->nome_fantasia) ? $config_empresa->nome_fantasia : "" ?>" required autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-2 col-lg-2">
                            <label>Telefone Fixo</label><span class="obrigatorio"> *</span>
                            <input class="form-control" type="text" name="telefone" fone_mask value="<?= isset($config_empresa->telefone) ? $config_empresa->telefone : "" ?>" autocomplete="off">
                        </div>
                        <div class="form-group col-md-2 col-lg-2">
                            <label>Celular</label>
                            <input class="form-control" type="text" name="celular" celular_mask value="<?= isset($config_empresa->celular) ? $config_empresa->celular : "" ?>" autocomplete="off">
                        </div>

                        <div class="form-group col-md-4 col-lg-4">
                            <label>Email</label><span class="obrigatorio"> *</span>
                            <input class="form-control" type="email" name="email" id="email" value="<?= isset($config_empresa->email) ? $config_empresa->email : "" ?>" required autocomplete="off">
                        </div>
                        <div class="form-group col-md-2 col-lg-2">
                            <label>CEP</label><span class="obrigatorio"> *</span>
                            <input class="form-control" type="text" id="cep" name="cep" value="<?= isset($config_empresa->cep) ? $config_empresa->cep : "" ?>" required cep_mask autocomplete="off" onchange="cep(this)" required>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <label>Estado</label><span class="obrigatorio"> *</span>
                            <select class="form-control" name="estado" id="estado" required>
                                <?php foreach ($estados as $estado) : ?>
                                    <option value="<?= $estado->uf; ?>" <?= ((isset($config_empresa->id_estado) ? $config_empresa->id_estado : "") == $estado->id) ? "selected" : ""; ?>><?= $estado->nome; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-lg-4">
                            <label>Cidade</label><span class="obrigatorio"> *</span>
                            <?php if (isset($config_empresa->id_cidade)) { ?>
                                <select class="form-control" name="id_cidade" id="cidade" required>
                                    <?php foreach ($cidades as $cidade) { ?>
                                        <option value="<?= $cidade->id ?>" <?= $cidade->id == $config_empresa->id_cidade ? 'selected="selected"' : '' ?>><?= $cidade->nome ?></option>
                                    <?php }  ?>
                                </select>
                            <?php } else { ?>
                                <select class="form-control" name="id_cidade" id="cidade" required>
                                </select>
                            <?php }  ?>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="nome">Endereço</label><span class="obrigatorio"><strong> *</strong></span>
                                <input class="form-control" type="text" id="endereco" name="endereco" value="<?= isset($config_empresa->endereco) ? $config_empresa->endereco : "" ?>" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <label for="nome">Número</label><span class="obrigatorio"> <strong> *</strong></span>
                                <input class="form-control" type="text" name="numero_endereco" value="<?= isset($config_empresa->numero_endereco) ? $config_empresa->numero_endereco : "" ?>" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="nome">Bairro</label><span class="obrigatorio"> <strong> *</strong></span>
                                <input class="form-control" type="text" id="bairro" name="bairro" value="<?= isset($config_empresa->bairro) ? $config_empresa->bairro : "" ?>" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-left">
                        <button type="button" class="btn btn-danger" onclick='location.href = "<?= URL . "home" ?>"'>Voltar <i class="fa fa-arrow-left icone-fa-left"></i></button>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-block btn-primary">Salvar <i class="fa fa-floppy-o icone-fa-left"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<?php if (isset($_GET['atualizado']) && $_GET['atualizado'] == 'true') { ?>
    <script>
        toastSucessMessage('Atualização realizada com sucesso!');
    </script>
<?php } ?>