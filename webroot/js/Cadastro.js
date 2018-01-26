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
        .always(function(data, status) {
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

    $('#find-cep').on('click', function() {
        var $cep = $('input[name=cep]');
        
        if (cep) {
            $.ajax({
                url: 'https://viacep.com.br/ws/' + $cep.cleanVal() + '/json/',
                dataType: 'json',
                method: 'GET'
            })
            .always(function(data, status) {
                $DOM = {
                    estado: $('select[name=estado] option'),
                    endereco: $('input[name=endereco]'),
                    cidade: $('select[name=cidade]'),
                    bairro: $('input[name=bairro]'),
                    messageBox: $('.message-box'),
                    cepInputDiv: $cep.closest('div'),
                    options: [],
                    option: null
                };

                if (status === 'success' && !data['erro']) {
                    var cidade = data.localidade.toUpperCase();

                    $DOM.cepInputDiv.removeClass('has-error');
                    $DOM.cidade.find('option').filter(function() {
                        return $(this).val() === cidade
                    }).prop('selected', true);
                    $DOM.estado.filter(function() {
                        return $(this).val() === data.uf;
                    }).prop('selected', true);
                    $DOM.endereco.val(data.logradouro);
                    $DOM.bairro.val(data.bairro);

                    if ($DOM.cidade.find('option:contains('+ cidade +')').length === 0) {
                        municipiosUF(data.uf).always(function(dataAjax, status) {
                            if (status === 'success' && dataAjax['municipios']) {
                                $.each(dataAjax['municipios'], function(index, value) {
                                    $DOM.option = $('<option></option>', {
                                        value: value['nome_municipio'], 
                                        text: value['nome_municipio']
                                    });
                                    if (value['nome_municipio'] === cidade) {
                                        $DOM.option.prop('selected', true);
                                    }
                                    $DOM.options.push($DOM.option);
                                });
                                $DOM.cidade.empty().append($DOM.options);
                            }   
                            else {
                                console.log('Error: não foi possível completar a requisição.');
                            }
                        });
                    }
                }
                else {
                    $DOM.cepInputDiv.addClass('has-error');
                    $DOM.messageBox.bootstrapAlert('error', 'CEP inválido, tente novamente.');
                    $DOM.estado.filter(function() {
                        return $(this).val() === 'AC'
                    }).prop('selected', true).change();
                    $DOM.bairro.val('');
                    $DOM.endereco.val('');
                }
            });
        }
    });

    $('select[name=estado]').on('change', function() {
        municipiosUF($(this).val()).always(function(data, status) {
            var $options = [];

            if (status === 'success' && data['municipios']) {
                $.each(data['municipios'], function(index, value) {
                    $options.push($('<option></option>', {
                        value: value['nome_municipio'], 
                        text: value['nome_municipio']
                    }));
                });
                
                $('select[name=cidade]').empty().append($options);
            }   
            else {
                console.log('Error: não foi possível completar a requisição.');
            }
        });
    });
});