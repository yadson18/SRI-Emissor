$(document).ready(function(){
	var $trToDelete = null;

	$('#destinatarie table .delete').on('click', function() {
		$('#destinatarie #delete .remove').attr({value: $(this).val()});
		$trToDelete = $(this).closest('tr');
	});

	$('#destinatarie #delete .remove').on('click', function() {
		$.ajax({
			url: '/Cadastro/delete',
			data: { cod_cadastro: $(this).val() },
			dataType: 'json',
			method: 'POST'
		})
		.always(function(data, status, a) {
			var $div = $('#destinatarie');
				$messageBox = $div.find('#message-box');

			if (status === 'success') {
				if (data['status'] === 'success') {
					if ($trToDelete && $trToDelete.length > 0) { 
						$trToDelete.remove(); 

						$div.find('table tbody tr th').each(function(index) { 
							$(this).text(++index); 
						});
					}
				}
				$messageBox.bootstrapAlert(data['status'], data['message']);
			}
			else { 
				$messageBox.bootstrapAlert(
					'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
				);
			}
		});
	});

	$('#delete .modal-footer .exit').on('click', function() {
		$(this).closest('div').find('button.remove').removeAttr('value');
	});
});