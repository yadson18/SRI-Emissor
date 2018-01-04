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
                $button.disable();
               
            }
        }).always(function(data, status) {
            if (status === 'success') {
                if (data['redirect']) {
                    $(location).attr('href', data['redirect']);
                }
                else {
                    alert(data['message']);
                }
            }
            else {
                $button.find('span').text('Entrar');
            }
        });
    });

    $.fn.extend({
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
});