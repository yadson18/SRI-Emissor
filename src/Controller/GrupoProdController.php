<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

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

		public function edit($cod_grupo = null, $subidentificador = null, $identificador = null, $pagina = 1)
		{
			$produto = TableRegistry::get('Produto');
			$grupo = $this->GrupoProd->newEntity();
			$usuario = $this->Auth->getUser();


			if (is_numeric($cod_grupo)) {
				if ($this->request->is('GET')) {
					$grupo = $this->GrupoProd->get($cod_grupo);
				}
				else if ($this->request->is('POST')) {
					$dados = array_map('removeSpecialChars', $this->request->getData());
					$grupo = $this->GrupoProd->patchEntity($grupo, $dados);
					$grupo->cod_grupo = $cod_grupo;
					
					if ($this->GrupoProd->save($grupo)) {
						$this->Flash->success(
							'Os dados do grupo (' . $grupo->descricao . ') foram modificados com sucesso.'
						);
					}
					else {
						$this->Flash->error(
							'Não foi possível modificar os dados do grupo (' . $grupo->descricao . ').'
						);
					}
				}
			}

			if (isset($grupo->descricao)) {
				$pagina = (is_numeric($pagina) && $pagina > 0) ? $pagina : 1;
				$produtos = null;

				$this->Paginator->showPage($pagina)
					->buttonsLink('/GrupoProd/edit/' . $cod_grupo . '/produtos/pagina/')
					->itensTotalQuantity(
						$produto->contarProdutosGrupo($cod_grupo)->quantidade
					)
					->limit(100);
				
				if ($subidentificador === 'produtos' && $identificador === 'pagina') {
					$produtos = $produto->getProdutosPorGrupo(
						$cod_grupo,
						$this->Paginator->getListQuantity(), 
						$this->Paginator->getStartPosition()
					);
				}
				else {
					$produtos = $produto->getProdutosPorGrupo(
						$cod_grupo,
						$this->Paginator->getListQuantity()
					);
				}
				
				$this->setViewVars([
					'usuarioNome' => $usuario->nome,
					'grupo' => $grupo,
					'produtos' => $produtos
				]);
			}
			else {
				$this->setViewVars([
					'usuarioNome' => $usuario->nome,
					'grupo' => null
				]);
			}
			$this->setTitle('Modificar Grupo');
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
			$this->Auth->isAuthorized(['index', 'delete', 'edit']);
		}
	}