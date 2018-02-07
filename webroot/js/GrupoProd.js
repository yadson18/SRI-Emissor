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

	$('#grupo-prod-index .group-content').each(function() {
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

	$('#grupo-prod-index #delete').on('show.bs.modal', function(evento) {
		var $DOM = {
            mensagem: $('#grupo-prod-index .groups-list .message-box'),
            botao: $(evento.relatedTarget)
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
	        			'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
	        		);
	        	}
	        });
        });
	})
	.on('hidden.bs.modal', function(evento) {
		$(this).find('.confirm').off('click');
	});

	$('#grupo-prod-edit #breadcrumb a').on('click', function() {
		$DOM = {
			abas: $('#grupo-prod-edit #breadcrumb li'),
			divProdutos: $('#grupo-prod-edit .produtos'),
			divSubgrupos: $('#grupo-prod-edit .subgrupos')
		};

		$DOM.abas.removeClass('active');
		$(this).parent().addClass('active');

		switch ($(this).attr('id')) {
			case 'PRODUTOS':
				$DOM.divProdutos.removeClass('hidden');
				$DOM.divSubgrupos.addClass('hidden');
				break;
			case 'SUBGRUPOS':
				$DOM.divSubgrupos.removeClass('hidden');
				$DOM.divProdutos.addClass('hidden');
				break;
		}
	});

	$('#grupo-prod-edit #delete').on('show.bs.modal', function(evento) {
		var $DOM = {
            mensagem: $('#grupo-prod-edit .form-body .message-box'),
            paginador: $('#grupo-prod-edit .list-shown'),
            botao: $(evento.relatedTarget)
        };

        $(this).find('.confirm').on('click', function() {
        	$DOM.linhaParaRemover = $('#' + $DOM.botao.val());

	        $.ajax({
	        	url: '/Produto/removerGrupo',
	        	method: 'POST',
	        	dataType: 'json',
	        	data: { cod_interno: $DOM.botao.val() }
	        })
	        .always(function(dados, status) {
	        	if (status === 'success') {
	        		if (dados.status === 'success') {
	        			$DOM.linhaParaRemover.remove();
	        			$DOM.paginador.find('.shown, .quantity').each(function() {
                            $(this).mask('000.000.000.000', { reverse: true }).text(
                                $(this).masked(parseInt($(this).cleanVal()) - 1)
                            );
                        });
                        $('#grupo-prod-edit table tbody th').each(function(indice) {
                            $(this).text(++indice);
                        });
	        		}
	        		$DOM.mensagem.bootstrapAlert(dados.status, dados.message);
	        	}
	        	else {
	        		$DOM.mensagem.bootstrapAlert(
	        			'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
	        		);
	        	}
	        });
        });
	})
	.on('hidden.bs.modal', function(evento) {
		$(this).find('.confirm').off('click');
	});
});