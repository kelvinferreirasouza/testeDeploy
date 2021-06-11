//exibe o nome do arquivo carregado, no botão de input file
function showFileName(inputFile) {
    inputFile.offsetParent.getElementsByClassName('fileName')[0].innerHTML = inputFile.value.replace(/\\/g, '/').split('/').pop();
}

function verificaImagensExclusao(event) {
    var sel = 0;

    $(".chk_img").each(function() {
        if ($(this).is(":checked")) {
            sel++;
        }
    });

    if (sel > 0) {
        swal({
            title: 'Atenção!',
            text: "Você tem certeza que deseja excluir as imagens selecionadas?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar <i class="fa fa-check"></i>',
            cancelButtonText: 'Cancelar <i class="fa fa-times"></i>',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#00a65a',
            reverseButtons: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result) {
                $('.form-deletar-imgs').submit();
                event.preventDefault();
            }
        });
    } else {
        swal({
            title: 'Atenção!',
            text: 'Você não selecionou nenhuma imagem para exclusão!',
            type: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Confirmar <i class="fa fa-check"></i>',
            confirmButtonColor: '#00a65a',
            reverseButtons: true,
            allowOutsideClick: false
        });

        event.preventDefault();
    }
}

jQuery(document).ready(function($) {

    $("a.fancy").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 600,
        'speedOut': 200,
        'overlayShow': false
    });

});

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

function formatExibicaoStrings(string) {

    string = string.toLowerCase();

    return string.charAt(0).toUpperCase() + string.slice(1);
}

function formatExibicaoMultiStrings(string) {

    string = string.toLowerCase();

    var nova_string = string.split(" ");
    var result = [];

    for (var i = 0; i < nova_string.length; i++) {
        result += nova_string[i].charAt(0).toUpperCase() + nova_string[i].slice(1);
        if (i < (nova_string.length - 1)) {
            result += ' ';
        }

    }

    return result;
}

function formataUnidade(numero, unidade) { // insere s na frente se for unidade maior que 1
    var plural = numero > 1 ? 's' : '';
    return numero + ' ' + unidade + plural;
}

function formataExibicaoData(date) { // exibe dd/mm/aaaa -- deve receber com o format date acima!
    data = new Date(date);
    dataFormatada = data.toLocaleDateString('pt-BR', { timeZone: 'UTC' });

    return dataFormatada;
}

function formataDataBanco(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = '' + d.getFullYear(),
        hour = '' + d.getHours(),
        minutes = '' + d.getMinutes();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    if (hour.length < 2) hour = '0' + hour;
    if (minutes.length < 2) minutes = '0' + minutes;

    var data = [day, month, year].join("/");
    var horas = [hour, minutes].join(":");

    return [data, horas].join(" ");
}


function numToMoeda(num) {
    return num.toLocaleString('pt-br', { minimumFractionDigits: 2 });
}

function numToMoedaFormatado(num, precision = false) {
    num = Number(num);

    if (!precision) {
        num = parseFloat(num.toFixed(2));
        return num.toLocaleString('pt-br', { minimumFractionDigits: 2 });

    } else {
        num = parseFloat(num.toFixed(precision));
        return num.toLocaleString('pt-br', { minimumFractionDigits: precision });
    }
}

function numToMoedaOneCase(num) {
    num = parseFloat(num.toFixed(0));
    return num.toLocaleString('pt-br', { minimumFractionDigits: 0 });
}

function moedaToNum(valor) {
    valor = valor.replace(/\./g, "");
    valor = valor.replace(/\,/g, ".");
    valor = Number(valor);
    return valor;
}

function somaTotalByClass(classe) {
    var inputs = new Array();

    $.each($(classe), function() {
        var valor = this.value;
        valor = valor.replace(/\./g, "");
        valor = valor.replace(/\,/g, ".");
        valor = Number(valor);
        valor = parseFloat(valor.toFixed(2));
        inputs.push(valor);
    });

    var total = 0;

    for (i = 0; i < inputs.length; i++) {
        total += inputs[i];
    }

    return total;
}

function somaTotalByClassSemMascara(classe) {
    var inputs = new Array();

    $.each($(classe), function() {
        var valor = this.value;
        valor = Number(valor);
        valor = parseFloat(valor.toFixed(2));
        inputs.push(valor);
    });

    var total = 0;

    for (i = 0; i < inputs.length; i++) {
        total += inputs[i];
    }

    return total;
}

function SomenteNumero(e) {
    var tecla;

    if (e.which) {
        tecla = e.which;
    } else {
        tecla = e.keyCode;
    }

    if ((tecla >= 48 && tecla <= 57) || (e.which == 08)) {
        return true;
    } else {
        e.preventDefault();
        return false;
    }
}

function SomenteLetras(e) {
    tecla = event.keyCode;
    if (tecla >= 33 && tecla <= 64 || tecla >= 91 && tecla <= 93 || tecla >= 123 && tecla <= 159 || tecla >= 162 && tecla <= 191) {
        e.preventDefault();
        return false;
    } else {
        return true;
    }
}


function SomenteLetrasENumeros(e) {
    tecla = event.keyCode;
    if ((tecla >= 33 && tecla <= 47) || (tecla > 57 && tecla <= 64) || tecla >= 91 && tecla <= 93 || tecla >= 123 && tecla <= 159 || tecla >= 162 && tecla <= 191) {
        e.preventDefault();
        return false;
    } else {
        return true;
    }
}

function alteraMaiusculo(campo) {
    var valor = $(campo).val();
    var novoTexto = valor.toUpperCase();
    $(campo).val(novoTexto);
}

function converteValorByMoeda(valor_item, valor_cotacao, tipo_moeda) {
    var ID_REAL = 1;
    var ID_DOLAR = 2;

    if (tipo_moeda == ID_DOLAR) {
        return valor_item * valor_cotacao;

    } else if (tipo_moeda == ID_REAL) {
        return valor_item;
    }
}

function converteToReal(valor_item, valor_cotacao) {
    return valor_item * valor_cotacao;
}

function isEmptyObject(obj) {
    var name;

    for (name in obj) return false;

    return true;
}

function addLoadingPri() {
    return new Promise(resolve => {
        setTimeout(() => {
            swal({
                title: 'Enviando...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                onOpen: () => {
                    swal.showLoading();
                }
            });
            resolve(true);
        }, 100);
    });
}

function removeLoadingPri() {
    return new Promise(resolve => {
        setTimeout(() => {
            swal.close();
            resolve(true);
            document.location.reload(true);
        }, 100);
    });
}

function somenteNumeros(e) {
    var charCode = e.charCode ? e.charCode : e.keyCode;
    // charCode 8 = backspace   
    // charCode 9 = tab
    if (charCode != 8 && charCode != 9) {
        // charCode 48 equivale a 0   
        // charCode 57 equivale a 9
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

function somenteNumerosVirgulaPonto(e) {
    var charCode = e.charCode ? e.charCode : e.keyCode;
    if (charCode != 8 && charCode != 9 && charCode != 44 && charCode != 46) {
        // charCode 48 equivale a 0   
        // charCode 57 equivale a 9
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

function validateFormatEmail(inputText) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputText.match(mailformat)) {
        return true;
    } else {
        return false;
    }
}

$(document).on('click', '.btn-isento', function() {
    $('#ie').val('ISENTO');
});