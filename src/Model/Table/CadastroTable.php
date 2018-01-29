<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class CadastroTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CADASTRO');

			$this->setPrimaryKey('cod_cadastro');

			$this->setBelongsTo('', []);
		}

		public function cadastroExistente(string $cnpj)
		{
			$cadastro = $this->find(['razao'])
				->from(['cadastro'])
				->where(['cnpj =' => unmask($cnpj)])
				->fetch('class');

			if ($cadastro) {
				return true;
			}
			return false;
		}

		public function validaCadastro(string $cnpj)
		{
			$cadastro = $this->find([
					'cod_cadastro', 'razao', 'cnpj', 
					'ativo', 'status', 'cod_reg_trib'
				])
				->from(['cadastro', 'contrato'])
				->where([
					'cnpj =' => unmask($cnpj), 'and',
					'cod_cadastro = contratante'
				])->fetch('class');

			if ($cadastro) {
				return $cadastro;
			}
			return false;	
		}

		public function normalizarDados(array $dadosCadastro)
		{
			if (isset($dadosCadastro['cnpj'])) {
				$dadosCadastro['cnpj'] = unmask($dadosCadastro['cnpj']);
			}
			if (isset($dadosCadastro['cep'])) {
				$dadosCadastro['cep'] = unmask($dadosCadastro['cep']);
			}

			return array_map('removeSpecialChars', $dadosCadastro);
		}

		public function listarAtivos(int $quantity = null, int $skipTo = null)
		{
			$cadastros = $this->find([
				'cod_cadastro', 'cnpj', 'razao', 'fantasia', 
				'estado', 'cidade', 'cep', 'endereco', 'bairro'
			]);

			if (!empty($quantity)) {
				$cadastros->limit($quantity);
			}
			if (!empty($skipTo)) {
				$cadastros->skip($skipTo);
			}
				
			return $cadastros->orderBy(['razao'])
				->where(['ativo =' => 'T'])
				->fetch('all');
		}

		public function contarAtivos()
		{
			return $this->find([])
				->count('cod_cadastro')->as('quantidade')
				->where(['ativo =' => 'T'])
				->fetch('class');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('empresa')->notEmpty()->int()->size(4);
			$validator->addRule('cod_cadastro')->notEmpty()->int()->size(5);
			$validator->addRule('razao')->empty()->string()->size(60);
			$validator->addRule('fantasia')->empty()->string()->size(40);
			$validator->addRule('cnpj')->empty()->string()->size(20);
			$validator->addRule('tipo')->empty()->string()->size(1);
			$validator->addRule('estadual')->empty()->string()->size(20);
			$validator->addRule('municipal')->empty()->string()->size(20);
			$validator->addRule('cae')->empty()->string()->size(10);
			$validator->addRule('endereco')->empty()->string()->size(40);
			$validator->addRule('bairro')->empty()->string()->size(30);
			$validator->addRule('cep')->empty()->string()->size(10);
			$validator->addRule('cidade')->empty()->string()->size(40);
			$validator->addRule('estado')->empty()->string()->size(20);
			$validator->addRule('telefone')->empty()->string()->size(20);
			$validator->addRule('fax')->empty()->string()->size(20);
			$validator->addRule('celular')->empty()->string()->size(20);
			$validator->addRule('contato')->empty()->string()->size(40);
			$validator->addRule('endcob')->empty()->string()->size(40);
			$validator->addRule('bairrocob')->empty()->string()->size(30);
			$validator->addRule('cepcob')->empty()->string()->size(10);
			$validator->addRule('cidadecob')->empty()->string()->size(40);
			$validator->addRule('estadocob')->empty()->string()->size(20);
			$validator->addRule('obs')->empty()->string()->size(1000);
			$validator->addRule('atividade')->empty()->int()->size(4);
			$validator->addRule('correspondencia')->empty()->string()->size(1);
			$validator->addRule('tributacao')->empty()->string()->size(1);
			$validator->addRule('comissao')->empty()->float()->size(8);
			$validator->addRule('vendedor')->empty()->int()->size(4);
			$validator->addRule('registro')->empty()->string()->size(1);
			$validator->addRule('deslocamento')->empty()->float()->size(8);
			$validator->addRule('ativo')->empty()->string()->size(1);
			$validator->addRule('multdistancia')->empty()->int()->size(8);
			$validator->addRule('multatividade')->empty()->int()->size(4);
			$validator->addRule('cadastrado_por')->empty()->int()->size(2);
			$validator->addRule('cadastrado_em')->empty()->string()->size(4);
			$validator->addRule('alterado_por')->empty()->int()->size(2);
			$validator->addRule('alterado_em')->empty()->string()->size(4);
			$validator->addRule('area')->empty()->string()->size(1);
			$validator->addRule('limite')->empty()->int()->size(8);
			$validator->addRule('ultimo_venc')->empty()->string()->size(4);
			$validator->addRule('atual_venc')->empty()->string()->size(4);
			$validator->addRule('prazo')->empty()->int()->size(4);
			$validator->addRule('tipo_fatura')->empty()->string()->size(10);
			$validator->addRule('datanasc')->empty()->string()->size(5);
			$validator->addRule('dia_fatuta')->empty()->string()->size(2);
			$validator->addRule('venc_cartao')->empty()->string()->size(4);
			$validator->addRule('cartao_proprio')->empty()->string()->size(1);
			$validator->addRule('senhacred')->empty()->string()->size(12);
			$validator->addRule('nrend1')->empty()->string()->size(12);
			$validator->addRule('nrend2')->empty()->string()->size(12);
			$validator->addRule('e_mail')->empty()->string()->size(100);
			$validator->addRule('cod_reg_trib')->notEmpty()->string()->size(1);
			$validator->addRule('tipocad')->notEmpty()->string()->size(1);
			$validator->addRule('st_liminar')->notEmpty()->string()->size(1);
			$validator->addRule('complementar')->empty()->string()->size(40);
			$validator->addRule('tabela_preco')->notEmpty()->int()->size(4);
			$validator->addRule('id_convenio')->empty()->int()->size(4);
			$validator->addRule('nr_convenio')->empty()->string()->size(100);
			$validator->addRule('cod_ctardz')->empty()->int()->size(4);
			$validator->addRule('dia_corte')->notEmpty()->int()->size(4);
			$validator->addRule('dia_vencimento')->notEmpty()->int()->size(4);
			$validator->addRule('protestar')->empty()->string()->size(1);
			$validator->addRule('dias_protestar')->empty()->int()->size(4);
			$validator->addRule('cpais')->notEmpty()->string()->size(4);
			$validator->addRule('trilha1')->empty()->string()->size(20);
			$validator->addRule('trilha2')->empty()->string()->size(20);
			$validator->addRule('trilha3')->empty()->string()->size(20);

			return $validator;
		}
	}