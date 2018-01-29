$(document).ready(function(){
    function moneyToFloat(money) {
        return parseFloat(money.replace(/[.]/g, '').replace(/[,]/g, '.'));
    }

    var $search;
    $('#find-ncscc').on('show.bs.modal', function (event) {
        $search = {
            method: 'POST',
            dataType: 'json'
        };

        var recipient = $(event.relatedTarget).data('find');
            $modal = $(this);

        $modal.find('.modal-title').text('Consultar ' + recipient.toUpperCase());
        switch (recipient) {
            case 'ncm':
                $search.url = '/Ncm/find';
                break;
            case 'cstpc':
                $search.url = '/ModPiscofins/find';
                break;
            case 'st':
                $search.url = '/St/find';
                break;
            case 'cfop':
                $search.url = '/Cfop/find';
                break;
            case 'cest':
                $search.url = '/Cest/find';
                break;
        }
    });

    $('#find-ncscc .find').on('click', function() {
        $DOM = {
            search: $('#find-ncscc .search-content'),
            filter: $('#find-ncscc .filter')
        };

        if ($DOM.search.val().replace(/[ ]/g, '') !== '' &&
            typeof $search === 'object'
        ) {
            $search.data = { 
                search: $DOM.search.val(),
                filter: $DOM.filter.val()
            };

            $.ajax($search).always(function(data, status) {
                console.log(data);
            });
        }
    });

    $('select[name=cod_grupo]').on('change', function() {
        $.ajax({
            url: '/SubgrupoProd/getSubgrupos',
            data: { codGrupo: $(this).val() },
            dataType: 'json',
            method: 'POST'
        }).always(function(data, status) {
            var $options = [];
            
            if (status === 'success' && data['subgrupos']) {
                $.each(data['subgrupos'], function(index, value) {
                    $options.push($('<option></option>', {
                        value: value['cod_subgrupo'],
                        text: value['descricao']
                    }));
                });
            }
            else {
                $options.push($('<option></option>', {
                    value: 0,
                    text: '-- SEM SUBGRUPO --'
                }));
            }
            $('select[name=cod_subgrupo]').empty().append($options);
        });
    });

    $('input[name=compra], input[name=markup]').on('keyup', function(){
        $DOM = {
            compra: $('input[name=compra]'),
            markup: $('input[name=markup]')
        };

        if ($DOM.compra.val().replace(/[0,.]/g, '') !== '' && 
            $DOM.markup.val().replace(/[0,.]/g, '') !== ''
        ) {
            var preco = moneyToFloat($DOM.compra.val());
                markup = parseFloat($DOM.markup.val());
                precoSugerido = (
                    preco + (preco * (markup / 100))
                ).toFixed(2).replace(/[.]/g, ',');

            $('.preco-sugerido').val(precoSugerido).maskMoney('mask');
        }
        else {
            $('.preco-sugerido').val('0,00');
        }
    });

    $('input[name=st]').on('keyup', function() {
        var $stCodigos = {
                normal: ['0010', '0030', '0060'],
                simples: ['0201', '0202', '0500']
            };
            $DOM = {
                divCest: $('#cest-block'),
                inputCestCod: $('#cest-block input[name=cest]'),
                inputRegTrib: $('#cod_reg_trib')
            };

        if ($stCodigos.normal.indexOf($(this).val()) !== -1 &&
            $DOM.inputRegTrib.val() === '3' || 
            $stCodigos.simples.indexOf($(this).val()) !== -1 &&
            $DOM.inputRegTrib.val() === '1'
        ) {
            $DOM.divCest.removeClass('hidden');
            $DOM.inputCestCod.val('').prop('required', true);
        }
        else {
            $DOM.divCest.addClass('hidden');
            $DOM.inputCestCod.val('0000000').prop('required', false);
        }
    }).keyup();
});