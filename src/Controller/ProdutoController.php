<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class ProdutoController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function index($identify = null, $page = 1)
		{	
			$page = (is_numeric($page) && $page > 0) ? (int) $page : 1;
			$ativos = $this->Produto->contarAtivos();
			$produtos = null;

			$this->Paginator->showPage($page)
				->buttonsLink('/Produto/index/page/')
				->itensTotalQuantity($ativos->quantidade)
				->limit(200);
			
			if ($identify === 'page' && !empty($page)) {
				$produtos = $this->Produto->listarAtivos(
					$this->Paginator->getListQuantity(), 
					$this->Paginator->getStartPosition()
				);
			}
			else {
				$produtos = $this->Produto->listarAtivos(
					$this->Paginator->getListQuantity()
				);
			}
			
			$this->setTitle('Produtos Cadastrados');
			$this->setViewVars([
				'usuarioNome' => $this->nomeUsuarioLogado(),
				'produtos' => $produtos
			]);
		}

		public function edit($cod_interno = null)
		{
			$unidadesMedida = $this->Produto->getUnidadesMedida();
			$produto = null;

			if (!empty($cod_interno)) {
				$produto = $this->Produto->get((int) $cod_interno);

				if ($produto) {
					$produto = $this->Produto->insertNcscm($produto);
				}
				if ($this->request->is('POST')) {
					$data = array_map('removeSpecialChars', $this->request->getData());
					$produtoEditado = $this->Produto->patchEntity(
						$this->Produto->newEntity(), $data
					);
					$produtoEditado->cod_interno = $cod_interno;
					
					if ($this->Produto->save($produtoEditado)) {
						$produto = $this->Produto->insertNcscm(
							$this->Produto->patchEntity($produto, $data)
						);

						$this->Flash->success('Os dados foram atualizados com sucesso.');
					}
					else {
						$this->Flash->error('Não foi possível atualizar os dados do produto.');
					}
				}
			}

			$this->setTitle('Modificar Produto');
			$this->setViewVars([
				'usuarioNome' => $this->nomeUsuarioLogado(),
				'produto' => $produto,
				'unidades' => $unidadesMedida
			]);
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit']);
		}
	}