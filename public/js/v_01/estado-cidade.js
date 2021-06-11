$(document).ready(function() {
    let uf_estado = $('#estado option:selected').val();

    if (uf_estado != "" && uf_estado != null) {
        $.ajax(url + "/ajax/getCidades/" + uf_estado, { async: false }).done(function(result) {
            $('#cidade').empty();
            let obj = jQuery.parseJSON(result);
            let id_cidade = $('#id_cidade_saved').val();

            for (let item in obj) {
                if (obj[item].id == id_cidade) {
                    $('#cidade').append($('<option>', {
                        value: obj[item].id,
                        text: obj[item].nome,
                        selected: 'selected'
                    }));
                } else {
                    $('#cidade').append($('<option>', {
                        value: obj[item].id,
                        text: obj[item].nome
                    }));
                }
            }
        });
    }

    $('#estado').on('change', function() {
        let uf_estado = $('#estado option:selected').val();
        if (uf_estado != "" && uf_estado != null) {
            $.ajax(url + "/ajax/getCidades/" + uf_estado, { async: false }).done(function(result) {
                $('#cidade').empty();
                let obj = jQuery.parseJSON(result);
                for (let item in obj) {
                    $('#cidade').append($('<option>', {
                        value: obj[item].id,
                        text: obj[item].nome
                    }));
                }
            });
        } else {
            $('#cidade').empty();
        }
    });
});