$(function() {
	if(dados_incorretos == 'true') {
		$('.box-senha').removeClass('has-error');
		$('.box-email').removeClass('has-error');
        $('.help-dados').remove();
        
        $('.box-senha').addClass('has-error');
        $('.box-email').addClass('has-error');
        $('.box-senha').append('<span class="help-block help-dados">Os dados informados estão incorretos</span>');

        $('#email').on('click', function() {
        	$('.box-senha').removeClass('has-error');
			$('.box-email').removeClass('has-error');
	        $('.help-dados').remove();
        });

        $('#senha').on('click', function() {
        	$('.box-senha').removeClass('has-error');
			$('.box-email').removeClass('has-error');
	        $('.help-dados').remove();
        });
	};
});