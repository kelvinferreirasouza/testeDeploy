$('#checkAll').click(function () {
    if(this.checked) {
        $('input:checkbox').prop('checked', true);
    } else {
        $('input:checkbox').prop('checked', false);
    }
});