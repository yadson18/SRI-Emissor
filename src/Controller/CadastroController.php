<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class CadastroController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function index($identify = null, $page = 1)
		{	
			$page = (is_numeric($page) && $page > 0) ? (int) $page : 1;
			$ativos = $this->Cadastro->contarAtivos();
			$cadastros = null;

			$this->Paginator->showPage($page)
				->buttonsLink('/Cadastro/index/page/')
				->itensTotalQuantity($ativos->quantidade)
				->limit(100);
			
			if ($identify === 'page' && !empty($page)) {
				$cadastros = $this->Cadastro->listarAtivos(
					$this->Paginator->getListQuantity(), 
					$this->Paginator->getStartPosition()
				);
			}
			else {
				$cadastros = $this->Cadastro->listarAtivos(
					$this->Paginator->getListQuantity()
				);
			}
			
			$this->setTitle('Listagem');
			$this->setViewVars([
				'usuarioNome' => $this->nomeUsuarioLogado(),
				'cadastros' => $cadastros
			]);
		}

		public function add()
		{
			$cadastro = $this->Cadastro->newEntity();
			$ibge = TableRegistry::get('Ibge');
			$estados = $ibge->siglaEstados();
			$municipios = null;

			if ($estados && isset($estados[0]['sigla'])) {
				$municipios = $ibge->municipiosUF($estados[0]['sigla']);
			}
			if ($this->request->is('POST')) {
				$data = array_map('sanitize', $this->request->getData());
				$cadastro = $this->Cadastro->patchEntity($cadastro, $data);
				$cadastro->ativo = 'T';

				if ($this->Cadastro->save($cadastro)) {
					$this->Flash->success('O destinatário foi adicionado com sucesso.');
				}
				else {
					$this->Flash->error('Não foi possível adicionar o destinatário.');
				}
			}

			$this->setTitle('Adicionar Destinatário');
			$this->setViewVars([
				'usuarioNome' => $this->nomeUsuarioLogado(),
				'estados' => $estados,
				'municipios' => $municipios
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

			if (!empty($cadastro) && !empty($estados) &&
				isset($cadastro->estado) && !empty($cadastro->estado)
			) {
				$cadastroTipo = (strlen($cadastro->cnpj) === 14) ? 'cnpj' : 'cpf';
				$municipios = $ibge->municipiosUF($cadastro->estado);
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

		public function delete()
		{
			if ($this->request->is('POST')) {
				$data = $this->request->getData();

				if (isset($data['cod_cadastro']) && !empty($data['cod_cadastro'])) {
					$cadastro = $this->Cadastro->find([
							'cod_cadastro', 'cnpj', 'razao'
						])
						->where(['cod_cadastro =' => (int) $data['cod_cadastro']])
						->fetch('class');

					if ($cadastro) {
						$cadastro->ativo = 'F';
						
						if ($this->Cadastro->save($cadastro)) {
							$this->Ajax->response('deleteCadastro', [
								'status' => 'success',
								'message' => 'O destinatário (' . $cadastro->razao . ') foi removido com sucesso.'
							]);
						}
						else {
							$this->Ajax->response('deleteCadastro', [
								'status' => 'error',
								'message' => 'Não foi possível remover o destinatário (' . $cadastro->razao . ').'
							]);
						}
					}
					else {
						$this->Ajax->response('deleteCadastro', [
							'status' => 'error',
							'message' => 'Não foi possível remover, o destinatário não existe.'
						]);
					}
				}
			}
			else {
				return $this->redirect(['controller' => 'Cadastro', 'view' => 'index']);
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit', 'add', 'delete', 'paginate']);
		}
	}