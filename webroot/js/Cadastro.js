$(document).ready(function(){
    function municipiosUF(siglaUF) {
        return $.ajax({
            url: '/Ibge/municipiosUF',
            data: { sigla: siglaUF },
            dataType: 'json',
            method: 'POST'
        });
    }

    var destinatarie = (function() {
        var cpf, cnpj, inscricaoEstadual;

        return {
            setCpf: function(cpfValue) {
                if (cpfValue.length === 14) { cpf = cpfValue; }
            },

            getCpf: function() { return cpf; },

            setCnpj: function(cnpjValue) {
                if (cnpjValue.length === 18) { cnpj = cnpjValue; }
            },

            getCnpj: function() { return cnpj; },

            setInscEstadual: function(inscEstadual) {
                inscricaoEstadual = inscEstadual;
            },
            getInscEstadual: function() { return inscricaoEstadual; }
        };
    })();

    var defaultMaskConfigs = {
        clearIfNotMatch: true,
        reverse: true,
        optional: false,
        translation: { '0': { pattern: /[0-9]/ } }
    };
    cnpj = { mask: '00.000.000/0000-00', size: 14 };
    cpf = { mask: '000.000.000-00', size: 11 };

    $('#breadcrumb .destinatarie-type a').on('click', function() {
        var $inputCnpjCpf = $('input[name=cnpj]');
            $labelCnpjCpf = $inputCnpjCpf.closest('div').find('label');
            $estadualDiv = $('div.estadual');
            $estadualInput = $estadualDiv.find('input');

        $('.destinatarie-type li').removeClass('active');
        $(this).parent().addClass('active');

        if ($(this).attr('id') === 'CPF') {
            if (!destinatarie.getInscEstadual()) {
                destinatarie.setInscEstadual($estadualInput.val());
            }
            if (!destinatarie.getCnpj()) {
                destinatarie.setCnpj($inputCnpjCpf.val());
            }

            $inputCnpjCpf.removeClass('cnpjMask').addClass('cpfMask').attr({ 
                    maxlength: 14, placeholder: 'EX: 095.726.241-80' 
                })
                .val(destinatarie.getCpf())
                .mask(cpf.mask, defaultMaskConfigs).focusout();

            $labelCnpjCpf.text('CPF');
            $estadualDiv.addClass('hidden');
            $estadualInput.removeAttr('name').attr({ required: false }).val('');
        }
        else {
            if (!destinatarie.getCpf()) {
                destinatarie.setCpf($inputCnpjCpf.val());
            }

            $inputCnpjCpf.removeClass('cpfMask').addClass('cnpjMask').attr({ 
                    maxlength: 18, placeholder: 'EX: 53.965.649/0001-03' 
                })
                .val(destinatarie.getCnpj())
                .mask(cnpj.mask, defaultMaskConfigs).focusout();

            $labelCnpjCpf.text('CNPJ');
            $estadualDiv.removeClass('hidden')
            $estadualInput.attr({ name: 'estadual', required: true })
                .val(destinatarie.getInscEstadual());
        }
    });

    $('#destinatarie #delete').on('show.bs.modal', function(evento) {
        var $DOM = {
            paginador: $('.list-shown .shown, .list-shown .quantity'),
            mensagem: $('#destinatarie #message-box'),
            botao: $(evento.relatedTarget)
        };

        $(this).find('button.confirm').on('click', function() {
            $DOM.linhaCadastro = $('#' + $DOM.botao.val());

            $.ajax({
                url: '/Cadastro/delete',
                method: 'POST',
                dataType: 'json',
                data: { cod_cadastro: $DOM.botao.val() }
            })
            .always(function(dados, status) {
                if (status === 'success') {
                    if (dados.status === 'success') {
                        $DOM.linhaCadastro.remove();
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

    $('#find-cep').on('click', function() {
        $DOM = {
            estado: $('select[name=estado] option'),
            cidade: $('select[name=cidade] option'),
            endereco: $('input[name=endereco]'),
            bairro: $('input[name=bairro]'),
            mensagem: $('.message-box'),
            cep: $('input[name=cep]'),
            opcoes: []
        };
        $DOM.cepDiv = $DOM.cep.closest('div');

        if ($DOM.cep.cleanVal().length === 8) {
            $.ajax({
                url: 'https://viacep.com.br/ws/' + $DOM.cep.cleanVal() + '/json/',
                dataType: 'json',
                method: 'GET',
                beforeSend: function() {
                    $DOM.cepDiv.removeClass('has-error');
                    $DOM.estado.parent().prop('disabled', true);
                    $DOM.cidade.parent().prop('disabled', true);
                    $DOM.endereco.prop('disabled', true);
                    $DOM.bairro.prop('disabled', true);
                }
            })
            .always(function(dados, status) {
                $DOM.estado.parent().prop('disabled', false);
                $DOM.cidade.parent().prop('disabled', false);
                $DOM.endereco.prop('disabled', false);
                $DOM.bairro.prop('disabled', false);

                if (status === 'success' && !dados.erro) {
                    var cidade = dados.localidade.toUpperCase();
                    $DOM.estado.filter(':contains('+ dados.uf +')').prop('selected', true);
                    $DOM.cidade.filter(':contains('+ cidade +')').prop('selected', true);
                    $DOM.endereco.val(dados.logradouro);
                    $DOM.bairro.val(dados.bairro);

                    if ($DOM.cidade.filter(':contains('+ cidade +')').length === 0) {
                        municipiosUF(dados.uf).always(function(dataAjax, status) {
                            if (status === 'success' && dataAjax.municipios) {
                                $.each(dataAjax.municipios, function(indice, valor) {
                                    $DOM.opcao = $('<option></option>', {
                                        value: valor.nome_municipio, 
                                        text: valor.nome_municipio
                                    });
                                    if (valor.nome_municipio === cidade) {
                                        $DOM.opcao.prop('selected', true);
                                    }
                                    $DOM.opcoes.push($DOM.opcao);
                                });
                                $DOM.cidade.parent().empty().append($DOM.opcoes);
                            }   
                            else {
                                $DOM.mensagem.bootstrapAlert(
                                    'error', 'Desculpe, não encontramos nenhum município relacionado a esse CEP.'
                                );
                            }
                        });
                    }
                }
                else {
                    $DOM.cepDiv.addClass('has-error');
                    $DOM.mensagem.bootstrapAlert('error', 'CEP inválido, tente novamente.');
                    $DOM.estado.filter(':contains(AC)').prop('selected', true).change();
                    $DOM.bairro.val('');
                    $DOM.endereco.val('');
                }
            });
        }
    });

    $('select[name=estado]').on('change', function() {
        $DOM = {
            cidade: $('select[name=cidade]'),
            mensagem: $('.message-box'),
            opcoes: []
        };
        $DOM.cidade.prop('disabled', true);

        municipiosUF($(this).val()).always(function(dados, status) {
            if (status === 'success' && dados.municipios) {
                $DOM.cidade.prop('disabled', false);
                
                $.each(dados.municipios, function(indice, valor) {
                    $DOM.opcoes.push($('<option></option>', {
                        value: valor.nome_municipio, 
                        text: valor.nome_municipio
                    }));
                });

                $DOM.cidade.empty().append($DOM.opcoes);
            }   
            else {
                $DOM.mensagem.bootstrapAlert(
                    'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
                );
            }
        });
    });
});