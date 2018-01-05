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
            $button.enable();

            if (status === 'success') {
                if (data['redirect']) {
                    $(location).attr('href', data['redirect']);
                }
                else {
                    $('#login #message-box').empty().append(
                        bootstrapAlert(data['status'], data['message'])
                    );
                }
            }
            else {
                $button.find('span').text('Entrar');
            }
        });
    });

    function bootstrapAlert(type, message)
    {
        var alert = '<div class="alert alert-%alert-type% alert-dismissable" role="alert">' +
                        '<button type="button" data-dismiss="alert" class="close" aria-label="Close">' +
                            '<i class="fa fa-times" aria-hidden="true"></i>' +
                        '</button>' +
                        '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + message +
                    '</div>';

        switch(type) {
            case 'success':
                return alert.replace('%alert-type%', 'success');
                break;
            case 'error':
                return alert.replace('%alert-type%', 'danger');
                break;
        }
    }

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