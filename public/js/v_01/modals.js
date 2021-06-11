// MODAL ATIVAR/DESATIVAR USUÁRIO

$('.btn-desativar-usuario').click(function() {
    $('#desativa-usuario').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "usuarios/desativarusuario/" + id);
});

$('.btn-ativar-usuario').click(function() {
    $('#ativa-usuario').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "usuarios/ativarusuario/" + id);
});

// MODAL ATIVAR/DESATIVAR BENEFÍCIO

$('.btn-desativar-beneficio').click(function() {
    $('#desativa-beneficio').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "beneficios/desativarbeneficio/" + id);
});

$('.btn-ativar-beneficio').click(function() {
    $('#ativa-beneficio').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "beneficios/ativarbeneficio/" + id);
});

// MODAL ATIVAR/DESATIVAR CARTÃO

$('.btn-desativar-cartao').click(function() {
    $('#desativa-cartao').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "cartoes/desativarcartao/" + id);
});

$('.btn-ativar-cartao').click(function() {
    $('#ativa-cartao').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "cartoes/ativarcartao/" + id);
});

// MODAL ATIVAR/DESATIVAR STATUS PAGAMENTO

$('.btn-desativar-status-pagamento').click(function() {
    $('#desativa-status-pagamento').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "statuspagamento/desativarstatuspagamento/" + id);
});

$('.btn-ativar-status-pagamento').click(function() {
    $('#ativa-status-pagamento').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "statuspagamento/ativarstatuspagamento/" + id);
});

// MODAL DESVINCULAR BENEFICIO

$('.btn-desvincular-beneficio').click(function() {
    $('#desvincular-beneficio').modal('show');
    var id = $(this).attr('id');
    $('.form-desvincular').attr('action', url + "cartoes/desvincularbeneficio/" + id_cartao + "/" + id);
});

// MODAL ATIVAR/DESATIVAR CÉLULA DE NEGÓCIO

$('.btn-desativar-celula-negocio').click(function() {
    $('#desativa-celula-negocio').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "celuladenegocio/desativarcelula/" + id);
});

$('.btn-ativar-celula-negocio').click(function() {
    $('#ativa-celula-negocio').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "celuladenegocio/ativarcelula/" + id);
});

// MODAL ATIVAR/DESATIVAR PLATAFORMAS

$('.btn-desativar-plataforma').click(function() {
    $('#desativa-plataforma').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "plataformas/desativarplataforma/" + id);
});

$('.btn-ativar-plataforma').click(function() {
    $('#ativa-plataforma').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "plataformas/ativarplataforma/" + id);
});

// MODAL ATIVAR/DESATIVAR VENDEDOR -> PLATAFORMA

$('.btn-desativar-vendedor-plataforma').click(function() {
    $('#desativa-vendedor-plataforma').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "plataformas/desativarvendedor/" + id_plataforma + "/" + id);
});

$('.btn-ativar-vendedor-plataforma').click(function() {
    $('#ativa-vendedor-plataforma').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "plataformas/ativarvendedor/" + id_plataforma + "/" + id);
});

// MODAL ATIVAR/DESATIVAR VENDEDOR

$('.btn-desativar-vendedor').click(function() {
    $('#desativa-vendedor').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "vendedores/desativarvendedor/" + id);
});

$('.btn-ativar-vendedor').click(function() {
    $('#ativa-vendedor').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "vendedores/ativarvendedor/" + id);
});

// MODAL ATIVAR/DESATIVAR CLIENTE

$('.btn-desativar-cliente').click(function() {
    $('#desativa-cliente').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "clientes/desativarcliente/" + id);
});

$('.btn-ativar-cliente').click(function() {
    $('#ativa-cliente').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "clientes/ativarcliente/" + id);
});

// MODAL ATIVAR/DESATIVAR PRAZO

$('.btn-desativar-prazo').click(function() {
    $('#desativa-prazo').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "prazos/desativarprazo/" + id);
});

$('.btn-ativar-prazo').click(function() {
    $('#ativa-prazo').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "prazos/ativarprazo/" + id);
});

// MODAL SELECIONAR PRODUTOS

$('#selecionar_produtos').click(function() {
    $('#mostra-produtos').modal('show');
});

// MODAL ATIVAR/DESATIVAR STATUS PEDIDO

$('.btn-desativar-status-pedido').click(function() {
    $('#desativa-status-pedido').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "statuspedido/desativarstatuspedido/" + id);
});

$('.btn-ativar-status-pedido').click(function() {
    $('#ativa-status-pedido').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "statuspedido/ativarstatuspedido/" + id);
});

// MODAL ATIVAR/DESATIVAR CATEGORIA

$('.btn-desativar-categoria').click(function() {
    $('#desativa-categoria').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "categorias/desativar/" + id);
});

$('.btn-ativar-categoria').click(function() {
    $('#ativa-categoria').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "categorias/ativar/" + id);
});

// MODAL ATIVAR/DESATIVAR USUÁRIO

$('.btn-desativar-cliente').click(function() {
    $('#desativa-cliente').modal('show');
    var id = $(this).attr('id');
    $('.form-desativar').attr('action', url + "clientes/desativar/" + id);
});

$('.btn-ativar-cliente').click(function() {
    $('#ativa-cliente').modal('show');
    var id = $(this).attr('id');
    $('.form-ativar').attr('action', url + "clientes/ativar/" + id);
});