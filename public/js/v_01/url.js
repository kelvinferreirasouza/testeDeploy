if ($('.nav-tabs').length >= 1) {
    var hash = window.location.hash;

    if (hash != '' && $(hash).length >= 1) {
        $('.tab-pane').removeClass('active');
        $(hash).addClass('active');
        $('.nav-tabs').find('li').removeClass('active');
        $('.nav-tabs').find('a[href="'+hash+'"]').parent().addClass('active');
    }
}