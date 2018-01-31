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

		public function add()
		{
			$produto = $this->Produto->newEntity();
			$subgrupo = TableRegistry::get('SubgrupoProd');
			$cstpc = TableRegistry::get('ModPiscofins');
			$unidade = TableRegistry::get('Unidades');
			$grupo = TableRegistry::get('GrupoProd');
			$ncscc = TableRegistry::get('Ncscc');
			$usuario = $this->Auth->getUser();

			if ($this->request->is('POST')) {
				$dados = $this->Produto->normalizarDados($this->request->getData());
				$produto = $this->Produto->patchEntity($produto, $dados);
				$validador = $ncscc->validaNCSCC(
					$produto->cod_ncm, $produto->cstpc, $produto->st, 
					$produto->cfop_in, $produto->cest
				);

				if ($validador['status'] === 'success') {
					$referencia = $cstpc->getCstpcRef($produto->cstpc)->referencia;
					$produto->cod_colaboradoralteracao = $usuario->cadastro->cod_cadastro;
					$produto->cod_colaboradorcadastro = $usuario->cadastro->cod_cadastro;
					$produto->data_alteracao = date('d.m.Y');
					$produto->data_cadastro = date('d.m.Y');
					$produto->cstpc_entrada = $referencia;

					if ($this->Produto->produtoExistente($produto->cod_produto)) {
						$this->Flash->error(
							'Desculpe, o código de barras (' . $produto->cod_produto . ') já está em uso.'
						);
					}
					else if ($this->Produto->save($produto)) {
						$this->Flash->success(
							'O produto (' . $produto->descricao . ') foi adicionado com sucesso.'
						);
					}
					else {
						$this->Flash->error(
							'Não foi possível adicionar o produto (' . $produto->descricao . ').'
						);
					}
				}
				else {
					$this->Flash->error($validador['message']);
				}
			}

			$this->setViewVars([
				'codRegTrib' => $usuario->cadastro->cod_reg_trib,
				'subgrupos' => $subgrupo->getSubgrupos(0),
				'unidades' => $unidade->get('all'),
				'usuarioNome' => $usuario->nome,
				'grupos' => $grupo->getGrupos()
			]);
			$this->setTitle('Adicionar Produto');
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
						$produto->data_alteracao = date('d.m.Y');
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

			if (isset($produto->cod_produto)) {
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

		public function delete()
		{
			$produto = $this->Produto->newEntity();
			$usuario = $this->Auth->getUser();

			if ($this->request->is('POST')) {
				$dados = $this->Produto->normalizarDados($this->request->getData());

				if (isset($dados['cod_interno']) && is_numeric($dados['cod_interno'])) {
					$paraApagar = $this->Produto->get($dados['cod_interno']);

					if ($paraApagar) {
						$produto = $this->Produto->patchEntity($produto, $dados);
						$produto->cod_colaboradoralteracao = $usuario->cadastro->cod_cadastro;
						$produto->data_alteracao = date('d.m.Y');
						$produto->inativo = 'I';

						if ($this->Produto->save($produto)) {
							$this->Ajax->response('produtoDeletado', [
								'status' => 'success',
								'message' => 'Produto (' . $paraApagar->descricao . ') removido com sucesso.'
							]);
						}
						else {
							$this->Ajax->response('produtoDeletado', [
								'status' => 'error',
								'message' => 'Não foi possível remover o produto (' . $paraApagar->descricao . ').'
							]);
						}
					}
				}
				else {
					$this->Ajax->response('produtoDeletado', [
						'status' => 'error',
						'message' => 'Não foi possível remover, o produto não existe.'
					]);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function enviarCarga()
		{
			$cargaProduto = TableRegistry::get('CargaProduto');

			if ($this->request->is('POST')) {
				$dados = $this->request->getData();
				array_walk_recursive($dados, 'removeSpecialChars');
				$conteudoCarga = null;

				if ($dados['cargaTipo'] === 'Geral') {
					$conteudoCarga = $this->Produto->cargaGeral();
				}
				else {
					$conteudoCarga = $cargaProduto->cargaParcial();
				}

				if ($conteudoCarga) {
					$conteudoCarga = $cargaProduto->normalizarCarga($conteudoCarga);
			 		$arquivoCarga = $cargaProduto->criarArquivoDeCarga($conteudoCarga);
					$arquivoCargaInfo = stream_get_meta_data($arquivoCarga);
					$nomeArquivoCarga = $cargaProduto->getNomeArquivoDeCarga($dados['cargaTipo']);
					$nomeArquivoOrigem = $arquivoCargaInfo['uri'];
					$diretorioCargas = ROOT . DS . 'CARGAS' . DS . 'carga' . DS;

					$resultado = [];
					foreach ($dados['caixas'] as $caixa) {
						$diretorioCaixa = $diretorioCargas . $caixa;

						if (is_dir($diretorioCaixa) || mkdir($diretorioCaixa)) {
							if (copy($nomeArquivoOrigem, $diretorioCaixa . DS . $nomeArquivoCarga)) {
								$resultado[$caixa] = [
									'status' => 'success',
									'message' => 'Carga enviada com sucesso.'
								];
							}
							else {
								$resultado[$caixa] = [
									'status' => 'error',
									'message' => 'Não foi possível gerar o arquivo de carga.'
								];
							}
						}
						else {
							$resultado[$caixa] = [
								'status' => 'error',
								'message' => 'Não foi possível gerar o arquivo de carga.'
							];
						}
					}

					$this->Ajax->response('cargaEnvio', [
						'status' => 'success',
						'data' => $resultado
					]);
				}
				else {
					if ($dados['cargaTipo'] === 'Geral') {
						$this->Ajax->response('cargaEnvio', [
							'status' => 'error',
							'message' => 'Não foi possível enviar a carga, nenhum produto cadastrado.'
						]);
					}
					else {
						$this->Ajax->response('cargaEnvio', [
							'status' => 'error',
							'message' => 'Não foi possível enviar a carga, nenhum produto foi alterado recentemente.'
						]);
					}
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function carga()
		{	
			$usuario = $this->Auth->getUser();
			$caixas = TableRegistry::get('ConfigCaixa');

			$this->setViewVars([
				'usuarioNome' => $usuario->nome,
				'caixas' => $caixas->getCaixas()
			]);
			$this->setTitle('Carga de Produtos');
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'add', 'edit', 'delete', 'carga', 'enviarCarga']);
		}
	}