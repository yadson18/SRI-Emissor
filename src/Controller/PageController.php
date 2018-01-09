<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class PageController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow(['index']);
		}

		public function index()
		{ 
			if ($this->Auth->getUser()) {
				return $this->redirect($this->Auth->loginRedirect());
			}

			$this->setTitle('Início');		
		}

		public function home()
		{
			$usuario = $this->Auth->getUser();
			$nfe = TableRegistry::get('Nfe')->quantidadeEmitidas();
			$produto = TableRegistry::get('Produto')->quantidadeCadastrados();

			$this->setTitle('Home');
			$this->setViewVars([
				'usuarioNome' => $this->nomeUsuarioLogado(),
				'usuarioRazao' => $usuario->cadastro->razao,
				'usuarioCnpj' => $usuario->cadastro->cnpj,
				'nfeEmitidas' => $nfe,
				'produtosCadastrados' => $produto 
			]);	
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['home']);
		}
	}