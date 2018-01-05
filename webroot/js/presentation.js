$(document).ready(function(){
    $('#enter').on('click', function() 
    {
        var $button = $(this);

        $.ajax({
            url: '/Colaborador/login',
            data: $('#login form').formToJSON(),
            method: 'POST',
            dataType: 'json',
            beforeSend: function() {
                $button.disable().find('span').text('Entrando...')
                    .parent().find('i').hide();
            }
        }).always(function(data, status) {
            $button.enable().find('span').text('Entrar')
                    .parent().find('i').show();

            if (status === 'success') {
                if (data['redirect']) {
                    $(location).redirect(data['redirect'])
                }
                else {
                    $('#login #message-box').bootstrapAlert(
                        data['status'], data['message']
                    );
                }
            }
            else {
                $button.find('span').text('Entrar');
            }
        });
    });

    $('input[name=cnpj]').mask('00.000.000/0000-00', {
        placeholder: '__.___.___/____-__',
        clearIfNotMatch: true,
        optional: false,
        translation: {'0': {pattern: /[0-9]/}}
    });
});