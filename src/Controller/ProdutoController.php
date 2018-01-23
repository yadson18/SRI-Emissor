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
			$unidadesMedida = [];
			$subgrupos = [];
			$grupos = [];
			$produto = null;

			if (!empty($cod_interno)) {
				$produto = $this->Produto->get((int) $cod_interno);

				if ($produto) {
					$produto = $this->Produto->inserirDadosProduto($produto);
					$unidadesMedida = $this->Produto->getUnidadesMedida();
					$grupos = $this->Produto->getGrupos();
					$subgrupos = $this->Produto->getSubgrupos($produto->cod_grupo);
				}
				if ($this->request->is('POST')) {
					$cod_cadastro = $this->Auth->getUser('cadastro')->cod_cadastro;
					$data = sanitizeProductValues($this->request->getData());

					$produtoEditado = $this->Produto->patchEntity(
						$this->Produto->newEntity(), $data
					);
					$produtoEditado->cod_interno = $cod_interno; 
					$produtoEditado->cod_colaboradoralteracao = $cod_cadastro; 

					if ($this->Produto->save($produtoEditado)) {
						$produto = $this->Produto->inserirDadosProduto(
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
				'unidades' => $unidadesMedida,
				'grupos' => $grupos,
				'subgrupos' => $subgrupos
			]);
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit']);
		}
	}