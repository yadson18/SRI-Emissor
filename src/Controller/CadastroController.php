<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class CadastroController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function index()
		{
			$this->setTitle('Listagem');
			$this->setViewVars([
				'usuarioNome' => $this->nomeUsuarioLogado(),
				'cadastros' => $this->Cadastro->listarAtivos()
			]);
		}

		public function edit($cod_cadastro = null)
		{
			$ibge = TableRegistry::get('Ibge');
			$estados = $ibge->siglaEstados();
			$municipios = null;
			$cadastro = null;
			$cadastroTipo = null;

			if (!empty($cod_cadastro)) {
				$cadastro = $this->Cadastro->get((int) $cod_cadastro);

				if (!empty($cadastro) && !empty($estados) &&
					isset($cadastro->estado) && !empty($cadastro->estado)
				) {
					$cadastroTipo = (strlen($cadastro->cnpj) === 14) ? 'cnpj' : 'cpf';
					$municipios = $ibge->municipiosUF($cadastro->estado);
				}
				
				if ($this->request->is('POST')) {
					$data = array_map('sanitize', $this->request->getData());
					$cadastroEditado = $this->Cadastro->patchEntity(
						$this->Cadastro->newEntity(), $data
					);
					$cadastroEditado->cod_cadastro = $cod_cadastro;
					
					if ($this->Cadastro->save($cadastroEditado)) {
						$cadastro = $this->Cadastro->patchEntity($cadastro, $data);

						$this->Flash->success('Os dados foram atualizados com sucesso.');
					}
					else {
						$this->Flash->error('Não foi possível atualizar os dados do destinatário.');
					}
				}
			}

			$this->setTitle('Modificar Destinatário');
			$this->setViewVars([
				'usuarioNome' => $this->nomeUsuarioLogado(),
				'cadastroTipo' => $cadastroTipo,
				'cadastro' => $cadastro,
				'estados' => $estados,
				'municipios' => $municipios
			]);
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit']);
		}
	}