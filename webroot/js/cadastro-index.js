$(document).ready(function(){
	$('table button.delete').on('click', function() {
		$('#delete .modal-footer a').attr({href: '/Cadastro/delete/' + $(this).val()});
	});

	$('#delete .modal-footer .exit').on('click', function() {
		$(this).closest('div').find('a').removeAttr('href');
	});
});