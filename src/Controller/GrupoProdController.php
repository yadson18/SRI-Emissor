<?php 
	namespace App\Controller;

	class GrupoProdController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function index($identificador = null, $pagina = 1)
		{
			$pagina = (is_numeric($pagina) && $pagina > 0) ? $pagina : 1;
			$usuario = $this->Auth->getUser();
			$grupos = null;

			$this->Paginator->showPage($pagina)
				->buttonsLink('/GrupoProd/index/pagina/')
				->itensTotalQuantity(
					$this->GrupoProd->contarAtivos()->quantidade
				)
				->limit(8);
			
			if ($identificador === 'pagina') {
				$grupos = $this->GrupoProd->listarGrupos(
					$this->Paginator->getListQuantity(), 
					$this->Paginator->getStartPosition()
				);
			}
			else {
				$grupos = $this->GrupoProd->listarGrupos(
					$this->Paginator->getListQuantity()
				);
			}
			
			$this->setTitle('Grupos Cadastrados');
			$this->setViewVars([
				'usuarioNome' => $usuario->nome,
				'grupos' => $grupos
			]);
		}

		/*public function edit()
		{
			if ($this->request->is('POST')) {
				
			}

			$cadastro = $this->Cadastro->newEntity();

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
		}*/

		public function getGrupoPorCod()
		{
			if ($this->request->is('POST')) {
				$dados = array_map('removeSpecialChars', $this->request->getData());

				if (isset($dados['cod_grupo']) && is_numeric($dados['cod_grupo'])) {
					$grupo = $this->GrupoProd->get($dados['cod_grupo']);

					if ($grupo) {
						$this->Ajax->response('dadosGrupo', [
							'status' => 'success',
							'data' => $grupo
						]);
					}
				}
				else {
					$this->Ajax->response('dadosGrupo', [
						'status' => 'error',
						'message' => 'Não foi possível carregar, o grupo não existe.'
					]);

				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function delete()
		{
			if ($this->request->is('POST')) {
				$dados = array_map('removeSpecialChars', $this->request->getData());

				if (isset($dados['cod_grupo']) && is_numeric($dados['cod_grupo'])) {
					$grupo = $this->GrupoProd->get($dados['cod_grupo']);

					if ($grupo) {
						if ($this->GrupoProd->remove($grupo)) {
							$this->Ajax->response('grupoDeletado', [
								'status' => 'success',
								'message' => 'O grupo (' . $grupo->descricao . ') foi removido com sucesso.'
							]);
						}
						else {
							$this->Ajax->response('grupoDeletado', [
								'status' => 'error',
								'message' => 'Não foi possível remover o grupo (' . $grupo->descricao . ').'
							]);
						}
					}
				}
				else {
					$this->Ajax->response('grupoDeletado', [
						'status' => 'error',
						'message' => 'Não foi possível remover, o grupo não existe.'
					]);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'delete', 'edit', 'getGrupoPorCod']);
		}
	}