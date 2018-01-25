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
				'usuarioNome' => $this->userLogado('nome'),
				'produtos' => $produtos
			]);
		}

		public function edit($codInterno = null)
		{
			$produto = null;

			if (is_numeric($codInterno)) {
				$codCadastro = $this->userLogado('cadastro')->cod_cadastro;
				$produto = $this->Produto->get($codInterno);

				if ($this->request->is('POST') && !is_null($produto)) {
					$produto = $this->Produto->patchEntity(
						$this->Produto->newEntity(), 
						normalizarDadosProduto($this->request->getData())
					);
					$produto->cod_colaboradoralteracao = $codCadastro;
					$produto->cod_interno = $codInterno; 

					if ($this->Produto->save($produto)) {
						$this->Flash->success('Os dados foram atualizados com sucesso.');
					}
					else {
						$this->Flash->error('Não foi possível atualizar os dados do produto.');
					}	
				}
			}
			if ($produto) {
				$this->setViewVars([
					'subgrupos' => $this->Produto->getSubgrupos($produto->cod_grupo),
					'codRegTrib' => $this->userLogado('cadastro')->cod_reg_trib,
					'cstpc' => $this->Produto->getCstpc($produto->cstpc),
					'cfop' => $this->Produto->getCfop($produto->cfop_in),
					'ncm' => $this->Produto->getNcm($produto->cod_ncm),
					'cest' => $this->Produto->getCest($produto->cest),
					'unidades' => $this->Produto->getUnidadesMedida(),
					'st' => $this->Produto->getSt($produto->st),
					'usuarioNome' => $this->userLogado('nome'),
					'grupos' => $this->Produto->getGrupos(),
					'produto' => $produto
				]);
			}
			else {
				$this->setViewVars([
					'usuarioNome' => $this->userLogado('nome'),
					'produto' => $produto
				]);
			}
			$this->setTitle('Modificar Produto');
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit']);
		}
	}