$(function() {
    
    $(document).ready(function() {
        var email_carregado = "";
        var libera_email = false;
        var libera_senha = false;

        email_carregado = $('#email').val();

        if(email_carregado != "") {
            libera_email = true;
        } else {
            libera_email = false;
        };

        $(".frmChecaUsuario #email, .frmChecaUsuario #senha, .frmChecaUsuario #confirmar_senha").on('blur', function() {
            var email = $('#email').val();
            var senha = $('#senha').val();
            var confirmar_senha = $('#confirmar_senha').val();

            if(email != "" && email != email_carregado) {
                $.ajax(url + "ajax/getPlataformaByEmail/" + email, {async: false}).done(function(result) {
                    if (result == 'true') {
                        $('.box-email').removeClass('has-error');
                        $('.help-email').remove();
                        libera_email = true;
                    } else if(result == 'false') {
                        $('.box-email').addClass('has-error');
                        $('.help-email').remove();
                        $('.box-email').append('<span class="help-block help-email">Este e-mail já está em uso</span>');
                        libera_email = false;
                    };
                });
            } else {
                $('.box-email').removeClass('has-error');
                $('.help-email').remove();
                libera_email = true;
            };

            if(senha != "" && confirmar_senha == "") {
                $('.box-senha').removeClass('has-error');
                    $('.help-senha').remove();

                    $('.box-senha').addClass('has-error');
                    $('.box-senha').append('<span class="help-block help-senha">As senhas não correspondem</span>');
                    libera_senha = false;

            } else if(senha != "" && confirmar_senha != "") {
                if (senha == confirmar_senha) {
                    $('.box-senha').removeClass('has-error');
                    $('.help-senha').remove();
                    libera_senha = true;
                } else {
                    $('.box-senha').removeClass('has-error');
                    $('.help-senha').remove();

                    $('.box-senha').addClass('has-error');
                    $('.box-senha').append('<span class="help-block help-senha">As senhas não correspondem</span>');
                    libera_senha = false;
                };
            };

            if(libera_senha == true && libera_email == true) {
                $('.btn-success').prop('disabled', false);
            } else {
                $('.btn-success').prop('disabled', true);
            };
        });
    });
});