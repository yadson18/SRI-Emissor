$(document).ready(function(){
	function pegarCorFundo(e) {
	    var v = null;
	    if (document.defaultView && document.defaultView.getComputedStyle) {
	        var cs = document.defaultView.getComputedStyle(e, null);
	        if (cs && cs.getPropertyValue) v = cs.getPropertyValue('background-color');
	    }
	    if (!v && e.currentStyle) v = e.currentStyle['backgroundColor'];
	    return v;
	}

	function calcularCor(dom) {
	    var $object = chroma(pegarCorFundo(dom));

	    if ($object.luminance() < 0.5) {
	    	return $object.brighten(4);	
	    } 
	    return $object.darken(0.5);	
	}

	$('#group div.group-content').each(function() {
		var $cor = calcularCor(this);
		var r = Math.round($cor._rgb.shift());
		var g = Math.round($cor._rgb.shift());
		var b = Math.round($cor._rgb.shift());
		var $estilo = { color: 'white' };

		if (r === g && r === b) {
			if (r <= 200 && g <= 200 && b <= 200) {
				$estilo.color = '#555';
			}
			else {
				$estilo.color = 'rgb('+ r +','+ g +','+ b +')';
			}
		}
		$(this).find('p').css($estilo);
	});

	$('#group #delete').on('show.bs.modal', function(evento) {
		var $DOM = {
            mensagem: $('#group #message-box'),
            botao: $(evento.relatedTarget),
            modal: $(this)
        };

        $(this).find('.confirm').on('click', function() {
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
		$(this).find('.confirm').off('click');
	});
});