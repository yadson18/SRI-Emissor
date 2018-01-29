<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class ProdutoController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function index($identificador = null, $pagina = 1)
		{	
			$pagina = (is_numeric($pagina) && $pagina > 0) ? $pagina : 1;
			$usuario = $this->Auth->getUser();
			$produtos = null;

			$this->Paginator->showPage($pagina)
				->buttonsLink('/Produto/index/pagina/')
				->itensTotalQuantity(
					$this->Produto->contarAtivos()->quantidade
				)
				->limit(200);
			
			if ($identificador === 'pagina') {
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
				'usuarioNome' => $usuario->nome,
				'produtos' => $produtos
			]);
		}

		public function edit($cod_interno = null)
		{
			$produto = $this->Produto->newEntity();
			$subgrupo = TableRegistry::get('SubgrupoProd');
			$cstpc = TableRegistry::get('ModPiscofins');
			$unidade = TableRegistry::get('Unidades');
			$grupo = TableRegistry::get('GrupoProd');
			$ncscc = TableRegistry::get('Ncscc');
			$cest = TableRegistry::get('Cest');
			$cfop = TableRegistry::get('Cfop');
			$usuario = $this->Auth->getUser();
			$ncm = TableRegistry::get('Ncm');
			$st = TableRegistry::get('St');

			if (is_numeric($cod_interno)) {
				if ($this->request->is('GET')) {
					$produto = $this->Produto->get($cod_interno);
				}
				else if ($this->request->is('POST')) {
					$dados = $this->Produto->normalizarDados($this->request->getData());
					$produto = $this->Produto->patchEntity($produto, $dados);
					$validador = $ncscc->validaNCSCC(
						$produto->cod_ncm, $produto->cstpc, $produto->st, 
						$produto->cfop_in, $produto->cest
					);

					if ($validador['status'] === 'success') {
						$referencia = $cstpc->getCstpcRef($produto->cstpc)->referencia;
						$produto->cod_colaboradoralteracao = $usuario->cadastro->cod_cadastro;
						$produto->cstpc_entrada = $referencia;
						$produto->cod_interno = $cod_interno;

						if ($this->Produto->save($produto)) {
							$this->Flash->success(
								'Os dados do produto (' . $produto->descricao . ') foram atualizados com sucesso.'
							);
						}
						else {
							$this->Flash->error(
								'Não foi possível atualizar os dados do produto (' . $produto->descricao . ').'
							);
						}
					}
					else {
						$this->Flash->error($validador['message']);
					}
				}
			}

			if (isset($produto->cod_interno)) {
				$this->setViewVars([
					'subgrupos' => $subgrupo->getSubgrupos($produto->cod_grupo),
					'cstpc' => $cstpc->getCstpcDescricao($produto->cstpc),
					'cfop' => $cfop->getCfopDescricao($produto->cfop_in),
					'ncm' => $ncm->getNcmDescricao($produto->cod_ncm),
					'cest' => $cest->getCestDescricao($produto->cest),
					'codRegTrib' => $usuario->cadastro->cod_reg_trib,
					'st' => $st->getStDescricao($produto->st),
					'unidades' => $unidade->get('all'),
					'grupos' => $grupo->getGrupos(),
					'usuarioNome' => $usuario->nome,
					'produto' => $produto
				]);
			}
			else {
				$this->setViewVars([
					'usuarioNome' => $usuario->nome,
					'produto' => null
				]);
			}
			$this->setTitle('Modificar Produto');
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit']);
		}
	}