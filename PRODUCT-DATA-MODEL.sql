INSERT INTO PRODUTO(
	cod_grupo, cod_subgrupo, cod_produto, descricao, unidade, balanca, fabricacao,
	compra, markup, venda, tipo_venda_volume, qtd_vol, preco_vol, data_inicio_prom,
	data_final_prom, preco_prom, descricao_promocao, cod_ncm, cstpc, cstpc_entrada, 
	ali_pis_debito, ali_cofins_debito, st, cest, icms_in, icms_out,
	cod_colaboradorcadastro, cod_colaboradoralteracao, data_cadastro, data_alteracao
) VALUES(
	7, 0, '7896002365480', 'ANA MARIA COM CHOCOLATE 80G', 'UN', 'N', 'P', 
	0.00, 0.00, 10.00, 'M', 0, 0.00, '03.07.2013, 00:00:00.000', 
	'03.07.2013, 00:00:00.000', 0.00, 'PROMOCAO', '19059090', 1, 50, 
	1.65, 1.65, '0000', '0000000', 0, 0, 
	88, 88, '03.07.2013', '03.07.2013'
)

update PRODUTO set 
	cod_grupo = '14', cod_subgrupo = '0', 
	cod_produto = '7891025431435', descricao = ' ACTIVIA LIQ AMEIXA LEITE FERMENTAD 180G', 
	unidade = 'UN', balanca = 'N', fabricacao = 'P', 
	compra = '1.86', markup = '25.00', venda = '2.65', 
	tipo_venda_volume = 'M', qtd_vol = '0', 
	preco_vol = '0.00', data_inicio_prom = '07.03.2013, 00:00:00.000', 
	data_final_prom = '07.03.2013, 00:00:00.000', preco_prom = '0.00', 
	descricao_promocao = 'ABCD', cod_ncm = '04039000', 
	cstpc = '6', cstpc_entrada = '50', ali_pis_debito = '000.00', 
	ali_cofins_debito = '000.00', st = '5102', cest = '1702200', 
	icms_in = '17.00', icms_out = '12.00', cod_colaboradorcadastro = 2, 
	cod_colaboradoralteracao = 2, data_cadastro = '23.01.2018', 
	data_alteracao = '23.01.2018'
where cod_interno = '15170'

[
    "cod_grupo" => "9",
    "cod_subgrupo" => "51",
    "cod_produto" => "7506195147405",
    "descricao" => "ABS ALWAYS BASICO C ABAS SECA L8P7",
    "unidade" => "UN",
    "balanca" => "N",
    "fabricacao" => "P",
    "compra" => "2.74",
    "markup" => "40.00",
    "venda" => "4.30",
    "tipo_venda_volume" => "M",
    "qtd_vol" => "0",
    "preco_vol" => "0.00",
    "data_inicio_prom" => "10.09.2013, 00:00:00.000",
    "data_final_prom" => "10.09.2013, 00:00:00.000",
    "preco_prom" => "0.00",
    "descricao_promocao" => "ABCDE",
    "cod_ncm" => "48184090",
    "cstpc" => "6",
    "cstpc_entrada" => "50",
    "ali_pis_debito" => "16.50",
    "ali_cofins_debito" => "76.00",
    "st" => "5405",
    "cest" => "2004200",
    "icms_in" => "0.00",
    "icms_out" => "0.00",
    "cod_colaboradorcadastro"  => 2,
    "cod_colaboradoralteracao"  => 2,
    "data_cadastro" => "23.01.2018",
    "data_alteracao" => "23.01.2018"
  ]