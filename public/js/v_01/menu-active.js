
$('.pagina').children('a').each(function() {
    var id_pagina = $(this).attr('id');

    if (id_pagina == id_menu) {
        $(this).parent('li').addClass('active');
        $(this).parent('li').parent('ul').parent('.pagina').addClass('active');
        $(this).parent('li').parent('ul').parent('li').addClass('active');
        $(this).parent('li').parent('ul').parent('li').parent('ul').parent('li').addClass('active');
    }
});
