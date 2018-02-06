$(document).ready(function(){
    function moneyToFloat(money) {
        return parseFloat(money.replace(/[.]/g, '').replace(/[,]/g, '.'));
    }

    $('#produto-index #delete').on('show.bs.modal', function(evento) {
        console.log('hi');
        var $DOM = {
            mensagem: $('#produto-index .produto-lista .message-box'),
            botao: $(evento.relatedTarget),
            paginador: $('#produto-index .list-shown')
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
                        $DOM.paginador.find('.shown, .quantity').each(function() {
                            $(this).mask('000.000.000.000', { reverse: true }).text(
                                $(this).masked(parseInt($(this).cleanVal()) - 1)
                            );
                        });
                        $('#produto-index table tbody th').each(function(indice) {
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

    var $promocao = (function() {
        var descricao = inicio = final = preco = null;

        return {
            setDescricao: function(descricaoValor) {
                if (descricao === null) {
                    descricao = descricaoValor;
                }
            },
            getDescricao: function() { 
                return descricao; 
            },
            setInicio: function(inicioValor) {
                if (inicio === null) {
                    inicio = inicioValor;
                }
            },
            getInicio: function() { 
                return inicio; 
            },
            setFinal: function(finalValor) {
                if (final === null) {
                    final = finalValor;
                }
            },
            getFinal: function() { 
                return final; 
            },
            setPreco: function(precoValor) {
                if (preco === null) {
                    preco = precoValor;
                }
            },
            getPreco: function() { 
                return preco; 
            }
        };
    })();

    $('input[name=qtd_vol]').on('change keyup', function() {
        var $DOM = {
            descricaoProm: $('input[name=descricao_promocao]'),
            inicioProm: $('input[name=data_inicio_prom]'),
            finalProm: $('input[name=data_final_prom]'),
            precoProm: $('input[name=preco_prom]')
        };
        var $propriedades = null;

        if ($(this).val().search(/^[1-9][1-9]*/g) !== -1 && $(this).val() > 1) {
            if ($promocao.getDescricao() && $promocao.getInicio() && 
                $promocao.getFinal() && $promocao.getPreco()
            ) {
                $DOM.descricaoProm.val($promocao.getDescricao());
                $DOM.inicioProm.val($promocao.getInicio());
                $DOM.finalProm.val($promocao.getFinal());
                $DOM.precoProm.val($promocao.getPreco());
            }
            $propriedades = { readonly: false, required: true };
            $DOM.descricaoProm.prop($propriedades).removeClass('disabled');
            $DOM.inicioProm.prop($propriedades).removeClass('disabled');
            $DOM.finalProm.prop($propriedades).removeClass('disabled');
            $DOM.precoProm.prop($propriedades).removeClass('disabled');

        }
        else {
            $propriedades = { readonly: true, required: false };
            $promocao.setDescricao($DOM.descricaoProm.val());
            $promocao.setInicio($DOM.inicioProm.val());
            $promocao.setFinal($DOM.finalProm.val());
            $promocao.setPreco($DOM.precoProm.val());

            $DOM.descricaoProm.prop($propriedades).addClass('disabled').val('');
            $DOM.inicioProm.prop($propriedades).addClass('disabled').val('');
            $DOM.finalProm.prop($propriedades).addClass('disabled').val('');
            $DOM.precoProm.prop($propriedades).addClass('disabled').val('0,00');
        }
    }).change();

    var buscaAnterior;
    
    $('#finder').on('show.bs.modal', function (evento) {
        var $DOM = {
            tabelaConteudo: $(this).find('table tbody'),
            buscarPor: $(this).find('.search-content'),
            divCarregando: $(this).find('.loading'),
            mensagem: $(this).find('.message-box'),
            filtro: $(this).find('.filter'),
            botao: $(evento.relatedTarget),
            modal: $(this)
        };
        var titulo = $DOM.botao.data('find');
        var url = '';

        switch (titulo) {
            case 'ncm': url = '/Ncm/find'; break;
            case 'cstpc': url = '/ModPiscofins/find'; break;
            case 'st': url = '/St/find'; break;
            case 'cfop': url = '/Cfop/find'; break;
            case 'cest': url = '/Cest/find'; break;
        }
        $DOM.modal.find('.modal-title').text('Consultar ' + titulo.toUpperCase());

        if (buscaAnterior !== titulo) {
            $DOM.tabelaConteudo.empty();
            $DOM.buscarPor.val('');
            buscaAnterior = titulo;
        }
        $(this).find('.find').on('click', function() {
            $DOM.tabelaConteudo.empty();
            $DOM.mensagem.empty();

            if (url && $DOM.filtro.val() && 
                $DOM.buscarPor.val().replace(/[ ]/g, '') !== ''
            ) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        filtro: $DOM.filtro.val(),
                        busca: $DOM.buscarPor.val()
                    },
                    beforeSend: function() {
                        $DOM.divCarregando.removeClass('hidden');
                    }
                })
                .always(function(dados, status) {
                    $DOM.divCarregando.addClass('hidden');

                    if (status === 'success') {
                        if (dados.status === 'success') {
                            var $linhas = [];

                            $.each(dados.data, function(indice, valor) {
                                $linhas.push($('<tr></tr>', {
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
                            $DOM.tabelaConteudo.append($linhas);
                        }
                        else {
                            $DOM.mensagem.bootstrapAlert(dados.status, dados.message);
                        }
                    }
                    else {
                        $DOM.mensagem.bootstrapAlert(
                            'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
                        );
                    }
                });
            }
            else {
                $DOM.mensagem.bootstrapAlert('error', 'Por favor, preencha o campo de busca e tente novamente.');
            }
        });
    })
    .on('hidden.bs.modal', function(evento) {
        $(this).find('.find').off('click');
    });

    $('.consultar button').on('click', function() {
        $('.consultar').removeClass('consultando');
        $(this).closest('div.consultar').addClass('consultando');
    });

    $(this).on('click', '#finder .select', function(){ 
        var $DOM = {
            linhasTabela: $('#finder table tbody tr'),
            selects: $('#finder .select')
        };

        $DOM.linhasTabela.removeClass('selected');
        $(this).closest('tr').addClass('selected');
        $DOM.selects.prop('checked', false); 
        $(this).prop('checked', true);  
    });

    $('#finder .inserir').on('click', function() {
        var $DOM = {
            linhaSelecionada: $('#finder .select:checked').closest('tr'),
            divSetDados: $('div.consultar.consultando .form-group'),
            mensagem: $('#finder .message-box')
        };

        if ($DOM.divSetDados.length > 0) {
            if ($DOM.linhaSelecionada.length > 0) {
                var codigo = $DOM.linhaSelecionada.find('.cod').text();
                var descricao = $DOM.linhaSelecionada.find('.descricao').text();

                if (codigo !== '' && descricao !== '') {
                    $DOM.divSetDados.find('input:nth-child(1)').val(codigo).change();
                    $DOM.divSetDados.find('input:nth-child(2)').val(descricao);
                    $(this).closest('.modal').modal('toggle');
                }
                else {
                    $DOM.mensagem.bootstrapAlert('error', 'Por favor, selecione um item cujo o código e descrição não sejam vazios.');
                }
            }
            else {
                $DOM.mensagem.bootstrapAlert('error', 'Desculpe, nenhum item foi selecionado.');
            }
        }
    });

    $('select[name=cod_grupo]').on('change', function() {
        $DOM = {
            subgrupo: $('select[name=cod_subgrupo]'),
            mensagem: $('.message-box')
        };

        $.ajax({
            url: '/SubgrupoProd/getSubgrupos',
            data: { cod_grupo: $(this).val() },
            dataType: 'json',
            method: 'POST',
            beforeSend: function() {
                $DOM.subgrupo.prop('disabled', true);
            }
        }).always(function(dados, status) {
            var $opcoes = [];
            
            if (status === 'success') {
                if (dados.status === 'success') {

                    $.each(dados.data, function(indice, valor) {
                        $opcoes.push($('<option></option>', {
                            value: valor.cod_subgrupo,
                            text: valor.descricao
                        }));
                    });
                }
                else {
                    $DOM.mensagem.bootstrapAlert(dados.status, dados.message);
                }
            }
            else {
                $opcoes.push($('<option></option>', {
                    value: 0,
                    text: '-- SEM SUBGRUPO --'
                }));
            }
            $DOM.subgrupo.empty().append($opcoes).prop('disabled', false);
        });
    });

    $('input[name=compra], input[name=markup]').on('keyup', function(){
        $DOM = {
            compra: $('input[name=compra]'),
            markup: $('input[name=markup]'),
            precoSugerido: $('.preco-sugerido')
        };

        var compra = moneyToFloat($DOM.compra.val());
        var markup = parseFloat($DOM.markup.val());
        var sugerido = (compra + (compra * (markup / 100))).toFixed(2);

        if (compra !== 0 && markup !== 0) {
            $DOM.precoSugerido.val(sugerido.replace(/[.]/g, ',')).maskMoney('mask');
        }
        else {
            $DOM.precoSugerido.val('0,00');
        }
    });

    $('input[name=st]').on('change', function() {
        var $DOM = {
            divCest: $('#cest-block'),
            cestCodigo: $('#cest-block input[name=cest]'),
            regimeTributario: $('#cod_reg_trib')
        };
        var $stCodigos = {
            normal: ['0010', '0030', '0060'],
            simples: ['0201', '0202', '0500']
        };

        if ($stCodigos.normal.indexOf($(this).val()) !== -1 &&
            $DOM.regimeTributario.val() === '3' || 
            $stCodigos.simples.indexOf($(this).val()) !== -1 &&
            $DOM.regimeTributario.val() === '1'
        ) {
            if ($DOM.cestCodigo.val() === '0000000') {
                $DOM.cestCodigo.val('');
            }

            $DOM.divCest.removeClass('hidden');
            $DOM.cestCodigo.prop('required', true);
        }
        else {
            $DOM.divCest.addClass('hidden');
            $DOM.cestCodigo.val('0000000').prop('required', false);
        }
    }).change();

    $('.enviar-carga').on('click', function() {
        var $DOM = {
            mensagem: $('#produto-carga .caixa-lista .message-box'),
            caixas: $('input[name=caixa-selecionado]:checked')
        };
        var caixasNumeros = [];

        if ($DOM.caixas.length > 0) {
            $DOM.caixas.each(function() { caixasNumeros.push($(this).val()); });

            $.ajax({
                url: '/Produto/enviarCarga',
                dataType: 'json',
                method: 'POST',
                data: { cargaTipo: $(this).val(), caixas: caixasNumeros },
                beforeSend: function() {
                    $DOM.trSelecionadas = $DOM.caixas.closest('tr').find('.status-envio');
                    $DOM.trSelecionadas.removeAttr('class').addClass('status-envio');
                    $DOM.trSelecionadas.find('p').text('Enviando...');
                    $DOM.trSelecionadas.find('i').removeAttr('class').addClass('fas fa-circle-notch fa-spin');
                }
            })
            .always(function(dados, status) {
                $DOM.mensagem.empty();
                
                if (status === 'success') {
                    if (dados.status === 'success' && dados.data) {
                        var $caixa = null;
                        var divClasse = '';
                        var iconeClasse = '';

                        $.each(dados.data, function(caixa, statusEnvio) {
                            $caixa = $('#' + caixa + ' .status-envio');

                            switch (statusEnvio.status) {
                                case 'success':
                                    divClasse = 'alert-success';
                                    iconeClasse = 'fas fa-check';
                                    break;
                                case 'error':
                                    divClasse = 'alert-danger';
                                    iconeClasse = 'fas fa-times';
                                    break;
                            }
                            $caixa.addClass(divClasse);
                            $caixa.find('p').text(statusEnvio.message);
                            $caixa.find('i').removeAttr('class').addClass(iconeClasse);
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
});