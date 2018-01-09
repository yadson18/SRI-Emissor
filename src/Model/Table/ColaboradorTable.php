<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use App\Model\Entity\Colaborador;
	use Simple\ORM\TableRegistry;
	use Simple\ORM\Table;

	class ColaboradorTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH2');

			$this->setTable('COLABORADOR');

			$this->setPrimaryKey('login');

			$this->setBelongsTo('', []);
		}

		public function login(Colaborador $colaborador)
		{
			if (isset($colaborador->login) && !empty($colaborador->login) &&
				isset($colaborador->senha) && !empty($colaborador->senha) &&
				isset($colaborador->cnpj) && !empty($colaborador->cnpj)
			) {
				$cadastro = TableRegistry::get('Cadastro')->validarCadastro(
					$colaborador->cnpj
				);

				if ($cadastro) {
					if ($cadastro->status !== 8) {
						$usuario = $this->find(['cod_colaborador', 'nome', 'funcao'])->where([
							'cod_cadastro =' => $cadastro->cod_cadastro, 'and',
							'login =' => $colaborador->login, 'and',
							'senha =' => $colaborador->senha
						])->fetch('class');

						if ($usuario) {
							$usuario->cadastro = $cadastro;

							return [
								'status' => 'success',
								'user' => $usuario
							];
						}
						return [
							'status' => 'error',
							'message' => 'Usuário ou senha incorreto, tente novamente.'
						];
					}
					return [
						'status' => 'error',
						'message' => 'Desculpe, este contrato foi cancelado, renove-o para continuar usando.'
					];
				}
				return [
					'status' => 'error',
					'message' => 'Nenhum contrato foi encontrado com o CNPJ informado.'
				];
			}
			return [
				'status' => 'error',
				'message' => 'Os campos CNPJ, usuário e senha, são obrigatórios.'
			];
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('empresa')->notEmpty()->int()->size(4);
			$validator->addRule('cod_colaborador')->notEmpty()->int()->size(4);
			$validator->addRule('nome')->empty()->string()->size(30);
			$validator->addRule('funcao')->empty()->int()->size(4);
			$validator->addRule('comissao')->empty()->float()->size(8);
			$validator->addRule('telefone')->empty()->string()->size(30);
			$validator->addRule('cpf')->empty()->string()->size(13);
			$validator->addRule('rg')->empty()->string()->size(15);
			$validator->addRule('endereco')->empty()->string()->size(40);
			$validator->addRule('bairro')->empty()->string()->size(30);
			$validator->addRule('cidade')->empty()->string()->size(30);
			$validator->addRule('uf')->empty()->string()->size(2);
			$validator->addRule('acesso')->notEmpty()->string()->size(100);
			$validator->addRule('login')->empty()->string()->size(20);
			$validator->addRule('senha')->notEmpty()->string()->size(12);
			$validator->addRule('ativo')->empty()->string()->size(1);
			$validator->addRule('cod_cadastro')->notEmpty()->int()->size(4);
			$validator->addRule('conectado')->empty()->string()->size(1);
			$validator->addRule('local')->empty()->string()->size(50);
			$validator->addRule('acesso2')->empty()->string()->size(100);
			$validator->addRule('email')->empty()->string()->size(100);

			return $validator;
		}
	}