$.fn.extend({
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

        return this.each(function() {
            $(this).empty().append($alert);
        });
    },
    redirect: function(location) 
    {
        if (location['controller'] && location['view']) {
            return this.each(function() {
                $(this).attr(
                    'href', '/' + location['controller'] + '/' + location['view']
                    );
            });
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