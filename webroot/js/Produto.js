$(document).ready(function(){
    function moneyToFloat(money) {
        return parseFloat(money.replace(/[.]/g, '').replace(/[,]/g, '.'));
    }

    $('.enviar-carga').on('click', function() {
        var $DOM = {
            caixas: $('input[name=caixa-selecionado]:checked'),
            mensagem: $('#carga #message-box')
        };
        var caixas = [];

        if ($DOM.caixas.length > 0) {
            $DOM.caixas.each(function() { caixas.push($(this).val()); });

            $.ajax({
                url: '/Produto/enviarCarga',
                dataType: 'json',
                method: 'POST',
                data: { cargaTipo: $(this).val(), caixas: caixas },
                beforeSend: function() {
                    $DOM.trSelecionadas = $DOM.caixas.closest('tr').find('.status-envio');
                    $DOM.trSelecionadas.removeAttr('class').addClass('status-envio');
                    $DOM.trSelecionadas.find('p').text('Enviando...');
                    $DOM.trSelecionadas.find('i').removeAttr('class').addClass('fas fa-circle-notch fa-spin');
                }
            })
            .always(function(dados, status) {
                if (status === 'success') {
                    if (dados.status === 'success' && dados.data) {
                        var $caixa = null;
                        var divClasse = '';
                        var iClasse = '';

                        $.each(dados.data, function(caixa, statusEnvio) {
                            $caixa = $('#' + caixa + ' .status-envio');

                            switch (statusEnvio.status) {
                                case 'success':
                                    divClasse = 'alert-success';
                                    iClasse = 'fas fa-check';
                                    break;
                                case 'error':
                                    divClasse = 'alert-danger';
                                    iClasse = 'fas fa-times';
                                    break;
                            }
                            $caixa.addClass(divClasse);
                            $caixa.find('p').text(statusEnvio.message);
                            $caixa.find('i').removeAttr('class').addClass(iClasse);
                        });
                    }
                    else {
                        $DOM.mensagem.bootstrapAlert(dados.status, dados.message);
                    }
                }
                else {
                    $DOM.mensagem.bootstrapAlert(
                        'warning', 'Não foi possível enviar a carga, verifique sua conexão com a internet.'
                    );
                }
            });
        }
        else {
            $DOM.mensagem.bootstrapAlert('error', 'Selecione no mínimo um caixa para enviar a carga.');
        }
    });

    $('input[name=selecionar-caixas]').on('click', function() {
        var $DOM = {
            caixas: $('input[name=caixa-selecionado]')
        };

        if ($(this).attr('id') === 'select') {
            $DOM.caixas.prop('checked', true);
        }
        else if ($(this).attr('id') === 'invert') {
            var selecionados = $DOM.caixas.filter(':checked');
            $DOM.caixas.prop('checked', true);
            selecionados.prop('checked', false);
        }
        else if ($(this).attr('id') === 'deselect') {
            $DOM.caixas.prop('checked', false);
        }
    });

    var $busca;
    $('#find-ncscc').on('show.bs.modal', function (evento) {
        var $DOM = {
            botao: $(evento.relatedTarget),
            modal: $(this)
        };
        var tipoConsulta = $DOM.botao.data('find');
        $busca = {
            method: 'POST',
            dataType: 'json'
        };

        $('.select-ncscc').removeClass('consulting');
        $DOM.modal.find('.modal-title').text('Consultar ' + tipoConsulta.toUpperCase());
        $DOM.botao.closest('.select-ncscc').addClass('consulting');
        $DOM.modal.find('.search-content').val('');
        $DOM.modal.find('table tbody').empty();

        switch (tipoConsulta) {
            case 'ncm': $busca.url = '/Ncm/find'; break;
            case 'cstpc': $busca.url = '/ModPiscofins/find'; break;
            case 'st': $busca.url = '/St/find'; break;
            case 'cfop': $busca.url = '/Cfop/find'; break;
            case 'cest': $busca.url = '/Cest/find'; break;
        }
    });

    var $promocao = (function() {
        var descricao = inicio = final = preco = null;

        return {
            setDescricao: function(descricaoValor) {
                if (descricao === null) {
                    descricao = descricaoValor;
                }
            },
            getDescricao: function() { return descricao; },

            setInicio: function(inicioValor) {
                if (inicio === null) {
                    inicio = inicioValor;
                }
            },
            getInicio: function() { return inicio; },

            setFinal: function(finalValor) {
                if (final === null) {
                    final = finalValor;
                }
            },
            getFinal: function() { return final; },

            setPreco: function(precoValor) {
                if (preco === null) {
                    preco = precoValor;
                }
            },
            getPreco: function() { return preco; }
        };
    })();
    $('input[name=qtd_vol]').on('change keyup', function() {
        var $DOM = {
            descricaoProm: $('input[name=descricao_promocao]'),
            inicioProm: $('input[name=data_inicio_prom]'),
            finalProm: $('input[name=data_final_prom]'),
            precoProm: $('input[name=preco_prom]')
        };
        var $properties = null;

        if ($(this).val() > 1) {
            if ($promocao.getDescricao() && $promocao.getInicio() && 
                $promocao.getFinal() && $promocao.getPreco()
            ) {
                $DOM.descricaoProm.val($promocao.getDescricao());
                $DOM.inicioProm.val($promocao.getInicio());
                $DOM.finalProm.val($promocao.getFinal());
                $DOM.precoProm.val($promocao.getPreco());
            }
            $properties = { readonly: false, required: true };
            $DOM.descricaoProm.prop($properties).removeClass('disabled');
            $DOM.inicioProm.prop($properties).removeClass('disabled');
            $DOM.finalProm.prop($properties).removeClass('disabled');
            $DOM.precoProm.prop($properties).removeClass('disabled');

        }
        else {
            $properties = { readonly: true, required: false };
            $promocao.setDescricao($DOM.descricaoProm.val());
            $promocao.setInicio($DOM.inicioProm.val());
            $promocao.setFinal($DOM.finalProm.val());
            $promocao.setPreco($DOM.precoProm.val());

            $DOM.descricaoProm.prop($properties).addClass('disabled').val('');
            $DOM.inicioProm.prop($properties).addClass('disabled').val('');
            $DOM.finalProm.prop($properties).addClass('disabled').val('');
            $DOM.precoProm.prop($properties).addClass('disabled').val('0,00');
        }
    }).change();

    $('#find-ncscc .find').on('click', function() {
        var $DOM = {
            mensagem: $('#find-ncscc .message-box'),
            tabelaConteudo: $('#find-ncscc table tbody'),
            filtro: $('#find-ncscc .filter'),
            buscarPor: $('#find-ncscc .search-content'),
            opcoes: []
        };
        
        $DOM.tabelaConteudo.empty();

        if ($DOM.buscarPor.val().replace(/[ ]/g, '') !== '' &&
            typeof $busca === 'object'
        ) {
            $busca.data = { 
                filtro: $DOM.filtro.val(),
                busca: $DOM.buscarPor.val()
            };

            $.ajax($busca).always(function(dados, status) {
                if (status === 'success') {
                    if (dados.status === 'success') {
                        $.each(dados.data, function(indice, valor) {
                            $DOM.opcoes.push($('<tr></tr>', {
                                html: [
                                    $('<th></th>', { text: (indice + 1) }),
                                    $('<td></td>', { 
                                        text: valor.codigo,
                                        class: 'cod'
                                    }),
                                    $('<td></td>', { 
                                        text: valor.descricao,
                                        class: 'descricao'
                                    }),
                                    $('<td></td>', { 
                                        html: $('<input/>', {
                                            class: 'select',
                                            type: 'checkbox'
                                        })
                                    })
                                ]
                            }));
                        });
                        
                        $DOM.mensagem.empty();
                        $DOM.tabelaConteudo.append($DOM.opcoes);
                    }
                    else {
                        $DOM.mensagem.bootstrapAlert('error', dados.message);
                    }
                }
                else {
                    $DOM.mensagem.bootstrapAlert('warning', 
                        'Desculpe, nada foi encontrado, verifique se tudo foi digitado corretamente.'
                    );
                }
            });
        }
        else {
            $DOM.mensagem.bootstrapAlert('error', 
                'O campo de busca não foi preenchido, preencha-o e tente novamente.'
            );
        }
    });

    $(this).on('click', '#find-ncscc .select', function(){ 
        var $DOM = {
            caixaSelecao: $('#find-ncscc .select'),
            linhaSelecionada: $(this).closest('tr')
        };

        $DOM.linhaSelecionada.addClass('selected');
        $DOM.caixaSelecao.prop('checked', false); 
        $(this).prop('checked', true); 
    });

    $('#find-ncscc .inserir').on('click', function() {
        var $DOM = {
            tabelaConteudo: $('#find-ncscc table tbody tr'),
            itemSelecionado: $('#find-ncscc .selected'),
            consultando: $('.consulting .form-group'),
            mensagem: $('#find-ncscc .message-box')
        };
        var codigo = $DOM.itemSelecionado.find('.cod').text();
        var descricao = $DOM.itemSelecionado.find('.descricao').text();
            
        if ($DOM.itemSelecionado.length > 0 && $DOM.consultando.length > 0 &&
            $DOM.tabelaConteudo.length > 0 && codigo !== '' && descricao !== ''
        ) {
            $DOM.mensagem.empty();
            $DOM.consultando.find('input:nth-child(1)').val(codigo).change();
            $DOM.consultando.find('input:nth-child(2)').val(descricao);
            $('#find-ncscc.modal').modal('toggle');
        }
        else {
            $DOM.mensagem.bootstrapAlert('error', 'Desculpe, nenhum item foi selecionado.');
        }
    });

    $('#product #delete').on('show.bs.modal', function(evento) {
        var $DOM = {
            paginador: $('.list-shown .shown, .list-shown .quantity'),
            mensagem: $('#product #message-box'),
            botao: $(evento.relatedTarget)
        };

        $(this).find('button.confirm').on('click', function() {
            $DOM.linhaParaRemover = $('#' + $DOM.botao.val());

            $.ajax({
                url: '/Produto/delete',
                method: 'POST',
                dataType: 'json',
                data: { cod_interno: $DOM.botao.val() }
            })
            .always(function(dados, status) {
                if (status === 'success') {
                    if (dados.status === 'success') {
                        $DOM.linhaParaRemover.remove();
                        $DOM.paginador.each(function() { 
                            $(this).text(
                                parseInt($(this).text().replace(/[.]/g, '')) - 1
                            ); 
                        });
                        $('#destinatarie table tbody th').each(function(indice) {
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
        $(this).find('button.confirm').off('click');
    });

    $('select[name=cod_grupo]').on('change', function() {
        $.ajax({
            url: '/SubgrupoProd/getSubgrupos',
            data: { codGrupo: $(this).val() },
            dataType: 'json',
            method: 'POST'
        }).always(function(dados, status) {
            var $options = [];
            
            if (status === 'success') {
                if (dados.status === 'success') {
                    $.each(dados.data, function(indice, valor) {
                        $options.push($('<option></option>', {
                            value: valor.cod_subgrupo,
                            text: valor.descricao
                        }));
                    });
                }
                else {
                    $DOM.mensagem.bootstrapAlert('error', dados.message);
                }
            }
            else {
                $options.push($('<option></option>', {
                    value: 0,
                    text: '-- SEM SUBGRUPO --'
                }));
            }
            $('select[name=cod_subgrupo]').empty().append($options);
        });
    });

    $('input[name=compra], input[name=markup]').on('keyup', function(){
        $DOM = {
            compra: $('input[name=compra]'),
            markup: $('input[name=markup]')
        };

        if ($DOM.compra.val().replace(/[0,.]/g, '') !== '' && 
            $DOM.markup.val().replace(/[0,.]/g, '') !== ''
        ) {
            var preco = moneyToFloat($DOM.compra.val());
                markup = parseFloat($DOM.markup.val());
                precoSugerido = (
                    preco + (preco * (markup / 100))
                ).toFixed(2).replace(/[.]/g, ',');

            $('.preco-sugerido').val(precoSugerido).maskMoney('mask');
        }
        else {
            $('.preco-sugerido').val('0,00');
        }
    });

    $('input[name=st]').on('change', function() {
        var $stCodigos = {
                normal: ['0010', '0030', '0060'],
                simples: ['0201', '0202', '0500']
            };
            $DOM = {
                divCest: $('#cest-block'),
                inputCestCodigo: $('#cest-block input[name=cest]'),
                inputRegimeTrib: $('#cod_reg_trib')
            };

        if ($stCodigos.normal.indexOf($(this).val()) !== -1 &&
            $DOM.inputRegimeTrib.val() === '3' || 
            $stCodigos.simples.indexOf($(this).val()) !== -1 &&
            $DOM.inputRegimeTrib.val() === '1'
        ) {
            if ($DOM.inputCestCodigo.val() === '0000000') {
                $DOM.inputCestCodigo.val('');
            }

            $DOM.divCest.removeClass('hidden');
            $DOM.inputCestCodigo.prop('required', true);
        }
        else {
            $DOM.divCest.addClass('hidden');
            $DOM.inputCestCodigo.val('0000000').prop('required', false);
        }
    }).change();
});