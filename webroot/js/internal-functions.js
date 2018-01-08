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