const ID_TIPO_PESSOA_FISICA = 1;
const ID_TIPO_PESSOA_JURIDICA = 2;

$('.id_tipo_cliente').on('click', function() {
    const id_tipo = $(this).val();
    verificaTipoCliente(id_tipo);
});

$(document).ready(function() {
    const id_tipo = $('.id_tipo_cliente:checked').val();
    verificaTipoCliente(id_tipo);
});

function verificaTipoCliente(id_tipo){
    debugger;
    if(id_tipo == ID_TIPO_PESSOA_JURIDICA){
        $(".dados_pessoa_juridica").show();

        $("#cpf_cnpj").inputmask({
            mask: ['99.999.999/9999-99'],
            keepStatic: true
        });

        $("#razao_social").prop('required', true);
        $("#nome_responsavel_empresa").prop('required', true);
        $("#cpf_responsavel_empresa").prop('required', true);

    }else{
        $("#razao_social").prop('required', false);
        $("#nome_responsavel_empresa").prop('required', false);
        $("#cpf_responsavel_empresa").prop('required', false);
        
        $("#cpf_cnpj").inputmask({
            mask: ['999.999.999-99'],
            keepStatic: true
        });

        $(".dados_pessoa_juridica").hide();
    }
}