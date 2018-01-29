<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class CadastroController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function index($identificador = null, $pagina = 1)
		{	
			$pagina = (is_numeric($pagina) && $pagina > 0) ? $pagina : 1;
			$usuario = $this->Auth->getUser();
			$cadastros = null;

			$this->Paginator->showPage($pagina)
				->buttonsLink('/Cadastro/index/pagina/')
				->itensTotalQuantity(
					$this->Cadastro->contarAtivos()->quantidade
				)
				->limit(100);

			if ($identificador === 'pagina') {
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
				'usuarioNome' => $usuario->nome,
				'cadastros' => $cadastros
			]);
		}

		public function add()
		{
			$cadastro = $this->Cadastro->newEntity();
			$ibge = TableRegistry::get('Ibge');
			$usuario = $this->Auth->getUser();

			if ($this->request->is('POST')) {
				$dados = $this->Cadastro->normalizarDados($this->request->getData());
				$cadastro = $this->Cadastro->patchEntity($cadastro, $dados);
				$cadastro->ativo = 'T';

				if ($this->Cadastro->cadastroExistente($cadastro->cnpj)) {
					$tipoCadastro = (strlen($cadastro->cnpj) === 18) ? 'CNPJ' : 'CPF';

					$this->Flash->error(
						'Desculpe, o ' . $tipoCadastro . ' (' . $cadastro->cnpj . ') já está em uso.'
					);
				}
				else if ($this->Cadastro->save($cadastro)) {
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
				'estados' => $ibge->siglaEstados(),
				'usuarioNome' => $usuario->nome
			]);
		}

		public function edit($cod_cadastro = null)
		{
			$cadastro = $this->Cadastro->newEntity();
			$ibge = TableRegistry::get('Ibge');
			$usuario = $this->Auth->getUser();

			if (is_numeric($cod_cadastro)) {
				if ($this->request->is('GET')) {
					$cadastro = $this->Cadastro->get($cod_cadastro);
				}
				else if ($this->request->is('POST')) {
					$dados = $this->Cadastro->normalizarDados($this->request->getData());
					$cadastro = $this->Cadastro->patchEntity($cadastro, $dados);
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

			if (isset($cadastro->cnpj)) {
				$this->setViewVars([
					'cadastroTipo' => (strlen($cadastro->cnpj)) ? 'cnpj' : 'cpf',
					'municipios' => $ibge->municipiosUF($cadastro->estado),
					'estados' => $ibge->siglaEstados(),
					'usuarioNome' => $usuario->nome,
					'cadastro' => $cadastro
				]);
			}
			else {
				$this->setViewVars([
					'usuarioNome' => $usuario->nome,
					'cadastro' => null
				]);
			}
			$this->setTitle('Modificar Destinatário');
		}

		public function delete()
		{
			$cadastro = $this->Cadastro->newEntity();

			if ($this->request->is('POST')) {
				$dados = $this->Cadastro->normalizarDados($this->request->getData());

				if (isset($dados['cod_cadastro']) && is_numeric($dados['cod_cadastro'])) {
					$paraApagar = $this->Cadastro->get($dados['cod_cadastro']);

					if ($paraApagar) {
						$cadastro = $this->Cadastro->patchEntity($cadastro, $dados);
						$cadastro->ativo = 'F';

						if ($this->Cadastro->save($cadastro)) {
							$this->Ajax->response('cadastroDeletado', [
								'status' => 'success',
								'message' => 'Destinatário (' . $paraApagar->razao . ') removido com sucesso.'
							]);
						}
						else {
							$this->Ajax->response('cadastroDeletado', [
								'status' => 'error',
								'message' => 'Não foi possível remover o destinatário (' . $paraApagar->razao . ').'
							]);
						}
					}
				}
				else {
					$this->Ajax->response('cadastroDeletado', [
						'status' => 'error',
						'message' => 'Não foi possível remover, o destinatário não existe.'
					]);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit', 'add', 'delete']);
		}
	}