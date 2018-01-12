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
                    case 'success':
                        addAlertClass($parentDiv, 'has-success');
                        break;
                    case 'error':
                        addAlertClass($parentDiv, 'has-error');
                        break;
                    case 'warning':
                        addAlertClass($parentDiv, 'has-warning');
                        break;
                    case 'none':
                        addAlertClass($parentDiv, 'has-none');
                        break;
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
    redirect: function(location) 
    {
        if (location['controller'] && location['view']) {
            $(this).attr(
                'href', '/' + location['controller'] + '/' + location['view']
            );
        }
    },
    disable: function() 
    {
        return this.each(function() { 
            $(this).prop('disabled', true); 
        });
    },
    enable: function() 
    {
        return this.each(function() { 
            $(this).prop('disabled', false); 
        });
    },
    formToJSON: function() 
    {
        var array, json;
        array = $(this).serializeArray();
        json = {};

        $.each(array, function() { 
            json[this.name] = this.value || ''; 
        });

        return json;
    }
});

$(document).ready(function(){
    function validateCpfCnpj(input, type)
    {
        if (typeof input === 'object') {
            var $form = input.closest('form'); 
                $div = input.closest('div');
                $messageBox = $('form .message-box');
                classes = '';

            if (input.prop('class').indexOf('cnpjMask') !== -1 &&
                input.val().length === 18 ||
                input.prop('class').indexOf('cpfMask') !== -1 &&
                input.val().length === 14
            ) {
                $div.addClass('icon-right').find('i').remove();

                if (type === 'success') {
                    $div.removeClass('has-error');
                    classes = 'fa-check success';
                }
                else if (type === 'error') {
                    $div.addClass('has-error');
                    classes = 'fa-times danger'; 
                }

               /* $form.submit(function(event) { 
                    if (type === 'success') {
                        event = null;
                        return;
                    }

                    event.preventDefault(); 
                    $messageBox.bootstrapAlert('error', 'CNPJ ou CPF inválido.');
                });*/

                $div.append($('<i></i>', { class: 'fas ' + classes }));
            }
        }
    }

    var defaultMaskConfigs = {
        clearIfNotMatch: true,
        reverse: true,
        optional: false,
        translation: { '0': { pattern: /[0-9]/ } }
    };
    cnpj = { mask: '00.000.000/0000-00', size: 14 };
    cpf = { mask: '000.000.000-00', size: 11 };

    $('.cnpjCpfMask').mask(function(value) { 
        return (value.length === cpf.size) ? cpf.mask : cnpj.mask;
    });

    $('.cnpjMask').mask(cnpj.mask, defaultMaskConfigs);

    $('.cpfMask').mask(cpf.mask, defaultMaskConfigs);

    $('.cnpjMask, .cpfMask').not('#login .cnpjMask').cpfcnpj({
        mask: false,
        validate: 'cpfcnpj',
        event: 'change',
        ifValid: function (input) { validateCpfCnpj(input, 'success'); },
        ifInvalid: function (input) { validateCpfCnpj(input, 'error'); }  
    });

    $('.cepMask').mask('00000-000', defaultMaskConfigs);

    $('input').on('change', function() { $(this).val($(this).val().toUpperCase()); });

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