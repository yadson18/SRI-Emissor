$(document).ready(function(){
	$('#groups #delete').on('show.bs.modal', function(evento) {
		var $DOM = {
            mensagem: $('#groups #message-box'),
            botao: $(evento.relatedTarget),
            modal: $(this)
        };

        $(this).find('button.confirm').on('click', function() {
        	$DOM.divGrupo = $('#' + $DOM.botao.val());

	        $.ajax({
	        	url: '/GrupoProd/delete',
	        	method: 'POST',
	        	dataType: 'json',
	        	data: { cod_grupo: $DOM.botao.val() }
	        })
	        .always(function(dados, status) {
	        	if (status === 'success') {
	        		if (dados.status === 'success') {
	        			$DOM.divGrupo.remove();
	        		}
	        		$DOM.mensagem.bootstrapAlert(dados.status, dados.message);
	        	}
	        	else {
	        		$DOM.mensagem.bootstrapAlert(
	        			'warning', 'Não foi possível enviar a carga, verifique sua conexão com a internet.'
	        		);
	        	}
	        });
        });
	})
	.on('hidden.bs.modal', function(evento) {
		$(this).find('button.confirm').off('click');
	});
});