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
			$page = (is_numeric($page) && $page > 0) ? $page : 1;
			$cadastros = null;

			$this->Paginator->showPage($page)
				->buttonsLink('/Cadastro/index/page/')
				->itensTotalQuantity(
					$this->Cadastro->contarAtivos()->quantidade
				)
				->limit(100);

			if ($identify === 'page') {
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
			
			$this->setTitle('Destinatários Cadastrados');
			$this->setViewVars([
				'usuarioNome' => $this->getUserName(),
				'cadastros' => $cadastros
			]);
		}

		public function add()
		{
			$cadastro = $this->Cadastro->newEntity();
			$ibge = TableRegistry::get('Ibge');

			if ($this->request->is('POST')) {
				$data = array_map('sanitize', $this->request->getData());
				$cadastro = $this->Cadastro->patchEntity($cadastro, $data);
				$cadastro->ativo = 'T';

				if ($this->Cadastro->save($cadastro)) {
					$this->Flash->success(
						'O destinatário (' . $cadastro->razao . ') foi adicionado com sucesso.'
					);
				}
				else {
					$this->Flash->error(
						'Não foi possível adicionar o destinatário (' . $cadastro->razao . ').'
					);
				}
			}

			$this->setTitle('Adicionar Destinatário');
			$this->setViewVars([
				'municipios' => $ibge->municipiosUF('AC'),
				'usuarioNome' => $this->getUserName(),
				'estados' => $ibge->siglaEstados()
			]);
		}

		public function edit($cod_cadastro = null)
		{
			$cadastro = $this->Cadastro->newEntity();

			if (is_numeric($cod_cadastro)) {
				if ($this->request->is('GET')) {
					$cadastro = $this->Cadastro->get($cod_cadastro);
				}
				else if ($this->request->is('POST')) {
					$data = array_map('sanitize', $this->request->getData());
					$cadastro = $this->Cadastro->patchEntity($cadastro, $data);
					$cadastro->cod_cadastro = $cod_cadastro;
						
					if ($this->Cadastro->save($cadastro)) {
						$this->Flash->success(
							'Os dados do destinatário (' . $cadastro->razao . ') foram modificados com sucesso.'
						);
					}
					else {
						$this->Flash->error(
							'Não foi possível modificar os dados do destinatário (' . $cadastro->razao . ').'
						);
					}
				}
			}
			else {
				$cadastro = null;
			}

			if ($cadastro) {
				$ibge = TableRegistry::get('Ibge');

				$this->setViewVars([
					'cadastroTipo' => (strlen($cadastro->cnpj) === 14) ? 'cnpj' : 'cpf',
					'municipios' => $ibge->municipiosUF($cadastro->estado),
					'usuarioNome' => $this->getUserName(),
					'estados' => $ibge->siglaEstados(),
					'cadastro' => $cadastro
				]);
			}
			else {
				$this->setViewVars([
					'usuarioNome' => $this->getUserName(),
					'cadastro' => $cadastro
				]);
			}
			$this->setTitle('Modificar Destinatário');
		}

		public function delete()
		{
			$cadastro = $this->Cadastro->newEntity();

			if ($this->request->is('POST')) {
				$data = $this->request->getData();

				if (is_numeric($data['cod_cadastro'])) {
					if ($this->Cadastro->get($data['cod_cadastro'])) {
						$cadastro = $this->Cadastro->patchEntity($cadastro, $data);
						$cadastro->ativo = 'F';

						if ($this->Cadastro->save($cadastro)) {
							$this->Ajax->response('deleteCadastro', [
								'status' => 'success',
								'message' => 'Destinatário removido com sucesso.'
							]);
						}
						else {
							$this->Ajax->response('deleteCadastro', [
								'status' => 'error',
								'message' => 'Não foi possível remover o destinatário.'
							]);
						}
					}
				}
				else {
					$this->Ajax->response('deleteCadastro', [
						'status' => 'error',
						'message' => 'Não foi possível remover, o destinatário não existe.'
					]);
				}
			}
			else {
				return $this->redirect(['controller' => 'Cadastro', 'view' => 'index']);
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit', 'add', 'delete']);
		}
	}