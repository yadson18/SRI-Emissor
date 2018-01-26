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
				'usuarioNome' => $this->getUserName(),
				'produtos' => $produtos
			]);
		}

		public function edit($codInterno = null)
		{
			$produto = null;

			if (is_numeric($codInterno)) {
				$produto = $this->Produto->get($codInterno);

				if ($this->request->is('POST') && $produto) {
					$produto = $this->Produto->patchEntity(
						$this->Produto->newEntity(), 
						normalizarDadosProduto($this->request->getData())
					);
					$validador = $this->Produto->validaNCSCC(
						$produto->cod_ncm, $produto->cstpc, $produto->st, 
						$produto->cfop_in, $produto->cest
					);

					if ($validador['status'] === 'success') {
						$referencia = $this->Produto->getCstpcRef($produto->cstpc)->referencia;
						$produto->cod_colaboradoralteracao = $this->getUserId();
						$produto->cstpc_entrada = $referencia;
						$produto->cod_interno = $codInterno;

						if ($this->Produto->save($produto)) {
							$this->Flash->success('Os dados foram atualizados com sucesso.');
						}
						else {
							$this->Flash->error('Não foi possível atualizar os dados do produto.');
						}
					}
					else {
						$this->Flash->error($validador['mensagem']);
					}
				}
			}
			if ($produto) {
				$this->setViewVars([
					'ncm' => $this->Produto->getNcmDescricao($produto->cod_ncm),
					'cstpc' => $this->Produto->getCstpcDescricao($produto->cstpc),
					'st' => $this->Produto->getStDescricao($produto->st),
					'cfop' => $this->Produto->getCfopDescricao($produto->cfop_in),
					'cest' => $this->Produto->getCestDescricao($produto->cest),
					'subgrupos' => $this->Produto->getSubgrupos($produto->cod_grupo),
					'codRegTrib' => $this->getUserRegTrib(),
					'unidades' => $this->Produto->getUnidadesMedida(),
					'usuarioNome' => $this->getUserName(),
					'grupos' => $this->Produto->getGrupos(),
					'produto' => $produto
				]);
			}
			else {
				$this->setViewVars([
					'usuarioNome' => $this->getUserName(),
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