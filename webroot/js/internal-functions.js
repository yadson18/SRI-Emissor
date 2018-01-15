$.fn.extend({
    notEmpty: function()
    {
        var tagName = $(this).prop('tagName');

        if (tagName === 'INPUT' || tagName === 'SELECT' ||
            tagName === 'TEXTAREA'
        ) {
            return ($(this).val().replace(/[ ]/g, '') !== '') ? true : false;
        }
        return ($(this).text().replace(/[ ]/g, '') !== '') ? true : false;
    },
    inputAlert: function(type) 
    {
        function addAlertClass($element, className)
        {
            var classesToReplace = [
                'has-error', 'has-success', 'has-warning', 'has-none'
            ];

            $.each(classesToReplace, function(index, className) {
                $element.removeClass(className);
            });
            $element.addClass(className);
        }

        return this.each(function() {
            var $parentDiv = $(this).closest('div');

            if ($parentDiv && type) {
                switch(type) {
                    case 'success': addAlertClass($parentDiv, 'has-success'); break;
                    case 'error': addAlertClass($parentDiv, 'has-error'); break;
                    case 'warning': addAlertClass($parentDiv, 'has-warning'); break;
                    case 'none': addAlertClass($parentDiv, 'has-none'); break;
                }
            }
        });
    },
    bootstrapAlert: function(alertType, message)
    {
        var $alert, $content;
        $alert = $('<div></div>', {
            class: 'alert alert-dismissable',
            role: 'alert',
            html: [
                $('<button></button>', {
                    type: 'button',
                    'data-dismiss': 'alert',
                    class: 'close',
                    'aria-label': 'Close',
                    html: $('<i></i>', {class: 'fas fa-times'})
                }),
                $('<div></div>', {
                    class: 'message-content',
                    html: [$('<i></i>', {class: 'fas'}), $('<span></span>')]
                })
            ]
        });
        $content = $alert.find('.message-content');
        $content.find('span').text(' ' + message);

        switch (alertType) {
            case 'success':
                $alert.addClass('alert-success');
                $content.find('i').addClass('fa-check-circle');
                break;
            case 'error':
                $alert.addClass('alert-danger');
                $content.find('i').addClass('fa-exclamation-circle');
                break;
            case 'info':
                $alert.addClass('alert-info');
                $content.find('i').addClass('fa-info-circle');
                break;
            case 'warning':
                $alert.addClass('alert-warning');
                $content.find('i').addClass('fa-exclamation-triangle');
                break;
        }

        $(this).find('.alert').remove();
        $(this).append($alert); 
    },
    redirect: function(redirect) 
    {
        if (redirect['controller'] && redirect['view']) {
            $(this).attr('href', '/' + redirect['controller'] + '/' + redirect['view']);
        }
    },
    disable: function() 
    {
        return this.each(function() { $(this).prop('disabled', true); });
    },
    enable: function() 
    {
        return this.each(function() { $(this).prop('disabled', false); });
    },
    formToJSON: function() 
    {
        var array = $(this).serializeArray();
        json = {};

        $.each(array, function() { json[this.name] = this.value || ''; });

        return json;
    }
});

$(document).ready(function(){
    function validateCpfCnpj($input, status)
    {
        var $div = $input.closest('div');
            $messageBox = $('form .message-box');
            classes = '';

        $div.addClass('icon-right').find('i').remove();

        if ($input.prop('class').indexOf('cnpjMask') !== -1 &&
            $input.val().length === 18 ||
            $input.prop('class').indexOf('cpfMask') !== -1 &&
            $input.val().length === 14
        ) { 
            if (status === 'success' && 
                !(/^(.)\1+$/.test($input.cleanVal()))
            ) {   
                classes = 'fa-check success';
                $div.removeClass('has-error');
            } 
            else {
                classes = 'fa-times danger';
                $div.addClass('has-error');

                if ($input.val().length === 18) {
                    $messageBox.bootstrapAlert('error', 'Digite um CNPJ válido.');
                }
                else {
                    $messageBox.bootstrapAlert('error', 'Digite um CPF válido.');
                }

            }
        }
        $div.append($('<i></i>', { class: 'fas ' + classes }));
    }

    var defaultMaskConfigs = {
        clearIfNotMatch: true,
        reverse: true,
        optional: false,
        translation: { '0': { pattern: /[0-9]/ } }
    };
    cnpj = { mask: '00.000.000/0000-00', size: 14 };
    cpf = { mask: '000.000.000-00', size: 11 };

    $('.cnpjMask').mask(cnpj.mask, defaultMaskConfigs);
    $('.cpfMask').mask(cpf.mask, defaultMaskConfigs);
    $('.cepMask').mask('00000-000', defaultMaskConfigs);

    $('.cnpjCpfMask').mask(function(value) { 
        return (value.length === cpf.size) ? cpf.mask : cnpj.mask;
    });

    $('.cnpjMask, .cpfMask').not('#login .cnpjMask').cpfcnpj({
        ifValid: function ($input) { validateCpfCnpj($input, 'success'); },
        ifInvalid: function ($input) { validateCpfCnpj($input, 'error'); }  
    });

    $('form').on('submit', function() {
        return ($(this).find('div.has-error').length === 0) ? true : false;
    });

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

    $('input').not('#login input').on('change', function() { 
        $(this).val($(this).val().toUpperCase()); 
    });

    $('select[name=estado]').on('change', function() {
        $.ajax({
            url: '/Ibge/municipiosUF',
            data: { sigla: $(this).val() },
            dataType: 'json',
            method: 'POST'
        })
        .always(function(data, status) {
            if (status === 'success') {
                var $cidadesSelect = $('select[name=cidade]');
                    $options = [];
                    municipio = null; 

                $.each(data, function(index, value) {
                    municipio = value['nome_municipio'];
                    $options.push($('<option></option>', {
                        value: municipio, 
                        text: municipio
                    }));
                });
                
                $cidadesSelect.empty().append($options);
            }   
            else {
                console.log('Error: não foi possível completar a requisição.');
            }
        });
    });
});