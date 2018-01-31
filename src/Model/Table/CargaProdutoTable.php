<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class CargaProdutoTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CARGA_PRODUTO');

			$this->setPrimaryKey('seq');

			$this->setBelongsTo('', []);
		}

		public function cargaParcial()
		{
			$cargaParcial = $this->find([
				'cod_produto', 'descricao', 'cod_grupo', 'cod_subgrupo', 'cod_linha', 'bruto', 
				'liquido', 'estoque', 'custo', 'icms_in', 'st', 'unidade', 'minimo' ,'aliquota', 
				'tipo', 'icms_out', 'cofins', 'federal', 'venda_markup', 'comissao', 'gondola', 
				'reservado', 'ult_compra', 'tipo_venda', 'maximo', 'cod_fabricante', 'mulcomissao', 
				'atacado', 'atacado1', 'atacado2', 'venda', 'data_ultcompra', 'data_cadastro', 
				'cod_colaboradorcadastro', 'data_alteracao', 'cod_colaboradoralteracao', 'qtd_embalagem', 
				'preco_embalagem', 'pauta', 'desc_atacado', 'qtd_ult_compra', 'data_ult_compra', 
				'preco_ult_compra', 'und_embalagem', 'qtd_antes_ult_compra', 'st_promocao', 'data_inicio_prom', 
				'data_final_prom', 'preco_prom', 'data_ult_venda', 'cod_barra_embalagem', 'balanca', 'cod_ncm', 
				'ex_ipi', 'cod_gen', 'cod_lst', 'indarrtrun', 'cstpc', 'mod_bcicms', 'mod_bcicmsst', 
				'ali_icmsst', 'fabricacao', 'qtd_vol', 'preco_vol', 'inativo', 'controla_estoque', 
				'descricao_promocao', 'pred_bcst', 'credito_in', 'credito_out', 'mva_in', 'mva_out', 'ali_ipi', 
				'cstipi', 'status', 'val_info', 'cfop_in', 'cfop_out', 'markup_varejo', 'venda_markup_varejo', 
				'status_inv', 'localizacao', 'bal_validade', 'crtl_serie', 'cod_receita_pis', 'cstpc_entrada', 
				'ali_pis_credito', 'ali_pis_debito', 'ali_cofins_credito', 'ali_cofins_debito', 'vasilhame', 
				'data_inv', 'familia', 'perc_ibpt', 'referencia', 'prfuturo', 'compra', 'markup', 
				'tipo_venda_volume', 'cest', 'cor', 'tamanho', 'perc_avista'
			])
			->orderBy(['seq'])->fetch('all');

			if ($cargaParcial) {
				return $cargaParcial;
			}
			return false;
		}

		public function normalizarCarga(array $dadosProduto)
		{
			$carga = array_map(function($produto) {
				return implode('|',
					array_map(function($coluna, $valor) {
						if (is_numeric($valor) && 
							preg_match('/[0-9]*[.][0-9]*$/', $valor)
						) {
							return ((float) $valor == 0) ? 0 : str_replace('.', ',', $valor);
						}
						else if (preg_match('/[0-9]*[-][0-9]*/', $valor)) {
							return date('d/m/Y H:i:s', strtotime($valor));
						}
						return $valor;

					}, 
					array_keys($produto), array_values($produto))
				);
			}, 
			array_values($dadosProduto));

			return implode("\r\n", $carga);
		}

		public function getNomeArquivoDeCarga(string $cargaTipo)
		{
			if ($cargaTipo === 'Geral' || $cargaTipo === 'Alterados') {
				return $cargaTipo .'_'. $this->gerarIdCarga() .'_'. date('Ymd') .'_'. date('His') .'_C.Cad';
			}
			return false;
		}

		public function criarArquivoDeCarga(string $conteudo)
		{
			$arquivoCarga = tmpfile();
			fwrite($arquivoCarga, $conteudo);
			
			return $arquivoCarga;
		}

		public function gerarIdCarga()
		{
			$id = $this->find(['gen_id(gen_num_lote_id,1)'])
				->from(['rdb$database'])
				->fetch('all');

			if($id){
				$id = array_shift($id)['gen_id'];
	
				if(strlen($id) < 6){
					return str_pad('', (6 - strlen($id)), '0', STR_PAD_LEFT) . $id;
				}	
				return $id;				
			}
			return '000000';
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq')->notEmpty()->int()->size(4);
			$validator->addRule('empresa')->empty()->int()->size(4);
			$validator->addRule('cod_interno')->empty()->int()->size(4);
			$validator->addRule('cod_produto')->notEmpty()->string()->size(14);
			$validator->addRule('descricao')->empty()->string()->size(40);
			$validator->addRule('cod_grupo')->empty()->int()->size(4);
			$validator->addRule('cod_subgrupo')->empty()->int()->size(4);
			$validator->addRule('cod_linha')->empty()->int()->size(4);
			$validator->addRule('bruto')->empty()->int()->size(4);
			$validator->addRule('liquido')->empty()->int()->size(4);
			$validator->addRule('estoque')->empty()->int()->size(8);
			$validator->addRule('custo')->empty()->int()->size(4);
			$validator->addRule('icms_in')->empty()->int()->size(2);
			$validator->addRule('st')->empty()->string()->size(4);
			$validator->addRule('unidade')->empty()->string()->size(2);
			$validator->addRule('minimo')->empty()->int()->size(4);
			$validator->addRule('aliquota')->empty()->string()->size(2);
			$validator->addRule('tipo')->empty()->string()->size(1);
			$validator->addRule('icms_out')->empty()->int()->size(2);
			$validator->addRule('cofins')->empty()->string()->size(1);
			$validator->addRule('federal')->empty()->int()->size(2);
			$validator->addRule('venda_markup')->empty()->int()->size(4);
			$validator->addRule('comissao')->empty()->int()->size(2);
			$validator->addRule('gondola')->empty()->int()->size(4);
			$validator->addRule('reservado')->empty()->int()->size(4);
			$validator->addRule('ult_compra')->empty()->int()->size(4);
			$validator->addRule('tipo_venda')->empty()->string()->size(1);
			$validator->addRule('maximo')->empty()->int()->size(4);
			$validator->addRule('cod_fabricante')->empty()->int()->size(4);
			$validator->addRule('mulcomissao')->empty()->int()->size(2);
			$validator->addRule('atacado')->empty()->int()->size(4);
			$validator->addRule('atacado1')->empty()->int()->size(4);
			$validator->addRule('atacado2')->empty()->int()->size(4);
			$validator->addRule('venda')->empty()->int()->size(4);
			$validator->addRule('data_ultcompra')->empty()->string()->size(8);
			$validator->addRule('data_cadastro')->empty()->string()->size(4);
			$validator->addRule('cod_colaboradorcadastro')->empty()->int()->size(4);
			$validator->addRule('data_alteracao')->empty()->string()->size(4);
			$validator->addRule('cod_colaboradoralteracao')->empty()->int()->size(4);
			$validator->addRule('qtd_embalagem')->empty()->int()->size(8);
			$validator->addRule('preco_embalagem')->empty()->int()->size(4);
			$validator->addRule('pauta')->empty()->int()->size(4);
			$validator->addRule('desc_atacado')->empty()->string()->size(50);
			$validator->addRule('qtd_ult_compra')->empty()->int()->size(4);
			$validator->addRule('data_ult_compra')->empty()->string()->size(4);
			$validator->addRule('preco_ult_compra')->empty()->int()->size(8);
			$validator->addRule('und_embalagem')->empty()->string()->size(10);
			$validator->addRule('qtd_antes_ult_compra')->empty()->int()->size(4);
			$validator->addRule('st_promocao')->empty()->string()->size(1);
			$validator->addRule('data_inicio_prom')->empty()->string()->size(8);
			$validator->addRule('data_final_prom')->empty()->string()->size(8);
			$validator->addRule('preco_prom')->empty()->int()->size(8);
			$validator->addRule('data_ult_venda')->empty()->string()->size(4);
			$validator->addRule('cod_barra_embalagem')->empty()->string()->size(14);
			$validator->addRule('balanca')->empty()->string()->size(1);
			$validator->addRule('cod_ncm')->empty()->string()->size(10);
			$validator->addRule('ex_ipi')->empty()->string()->size(10);
			$validator->addRule('cod_gen')->empty()->int()->size(4);
			$validator->addRule('cod_lst')->empty()->int()->size(4);
			$validator->addRule('indarrtrun')->empty()->string()->size(1);
			$validator->addRule('cstpc')->empty()->int()->size(4);
			$validator->addRule('mod_bcicms')->empty()->string()->size(2);
			$validator->addRule('mod_bcicmsst')->empty()->string()->size(2);
			$validator->addRule('ali_icmsst')->empty()->string()->size(2);
			$validator->addRule('fabricacao')->empty()->string()->size(1);
			$validator->addRule('qtd_vol')->empty()->int()->size(4);
			$validator->addRule('preco_vol')->empty()->int()->size(4);
			$validator->addRule('inativo')->empty()->string()->size(1);
			$validator->addRule('controla_estoque')->empty()->string()->size(1);
			$validator->addRule('descricao_promocao')->empty()->string()->size(25);
			$validator->addRule('pred_bcst')->empty()->int()->size(2);
			$validator->addRule('credito_in')->empty()->int()->size(2);
			$validator->addRule('credito_out')->empty()->int()->size(2);
			$validator->addRule('mva_in')->empty()->int()->size(8);
			$validator->addRule('mva_out')->empty()->int()->size(8);
			$validator->addRule('ali_ipi')->empty()->int()->size(2);
			$validator->addRule('cstipi')->empty()->int()->size(4);
			$validator->addRule('status')->empty()->string()->size(1);
			$validator->addRule('val_info')->empty()->string()->size(300);
			$validator->addRule('cfop_in')->empty()->string()->size(4);
			$validator->addRule('cfop_out')->empty()->string()->size(4);
			$validator->addRule('markup_varejo')->empty()->int()->size(4);
			$validator->addRule('venda_markup_varejo')->empty()->int()->size(4);
			$validator->addRule('status_inv')->empty()->string()->size(1);
			$validator->addRule('localizacao')->empty()->string()->size(25);
			$validator->addRule('bal_validade')->empty()->int()->size(4);
			$validator->addRule('crtl_serie')->empty()->string()->size(1);
			$validator->addRule('cod_receita_pis')->empty()->string()->size(3);
			$validator->addRule('cstpc_entrada')->empty()->int()->size(4);
			$validator->addRule('ali_pis_credito')->empty()->int()->size(4);
			$validator->addRule('ali_pis_debito')->empty()->int()->size(4);
			$validator->addRule('ali_cofins_credito')->empty()->int()->size(4);
			$validator->addRule('ali_cofins_debito')->empty()->int()->size(4);
			$validator->addRule('vasilhame')->empty()->string()->size(1);
			$validator->addRule('data_inv')->empty()->string()->size(4);
			$validator->addRule('familia')->empty()->int()->size(4);
			$validator->addRule('perc_ibpt')->empty()->int()->size(8);
			$validator->addRule('referencia')->empty()->string()->size(14);
			$validator->addRule('prfuturo')->empty()->int()->size(4);
			$validator->addRule('compra')->empty()->int()->size(4);
			$validator->addRule('markup')->empty()->int()->size(4);
			$validator->addRule('num_lote')->empty()->int()->size(4);
			$validator->addRule('tipo_venda_volume')->empty()->string()->size(1);
			$validator->addRule('cest')->empty()->string()->size(7);

			return $validator;
		}
	}