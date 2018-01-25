$(document).ready(function(){
    function moneyToFloat(money) {
        return parseFloat(money.replace(/[.]/g, '').replace(/[,]/g, '.'));
    }

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

    $('input#cod-cst-st').on('keyup', function() {
        $('input[name=st]').val($(this).val());
        
        var $stRegTrib = {
                normal: ['0010', '0030', '0060'],
                simples: ['0201', '0202', '0500']
            };
            $DOM = {
                divCest: $('#cest-block'),
                inputCestCod: $('#cest-block input[name=cest]'),
                inputCest: $('#cest-block #codigo-cest'),
                inputRegTrib: $('#cod_reg_trib')
            };

        if ($stRegTrib.normal.indexOf($(this).val()) !== -1 &&
            $DOM.inputRegTrib.val() === '3' || 
            $stRegTrib.simples.indexOf($(this).val()) !== -1 &&
            $DOM.inputRegTrib.val() === '1'
        ) {
            $DOM.divCest.removeClass('hidden');
            $DOM.inputCestCod.val($DOM.inputCest.val());
            $DOM.inputCest.prop('required', true);
        }
        else {
            $DOM.divCest.addClass('hidden');
            $DOM.inputCestCod.val('0000000');
            $DOM.inputCest.prop('required', false);
        }
    }).keyup();

    $('input#codigo-cfop').on('keyup', function() {
        $('input[name=cfop_in]').val($(this).val());
    });

    $('input#codigo-cest').on('keyup', function() {
        $('input[name=cest]').val($(this).val());
    });

    $('input#codigo-ncm').on('keyup', function() {
        $('input[name=cod_ncm]').val($(this).val());
    });

    $('input#codigo-cst').on('keyup', function() {
        $('input[name=cstpc]').val($(this).val());
    });
});