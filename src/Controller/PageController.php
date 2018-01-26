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
			$produto = TableRegistry::get('Produto')->quantidadeCadastrados();
			$nfe = TableRegistry::get('Nfe')->quantidadeEmitidas();
			$usuario = $this->Auth->getUser();

			$this->setTitle('Home');
			$this->setViewVars([
				'usuarioRazao' => $usuario->cadastro->razao,
				'usuarioCnpj' => $usuario->cadastro->cnpj,
				'usuarioNome' => $this->getUserName(),
				'produtosCadastrados' => $produto,
				'nfeEmitidas' => $nfe
			]);	
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['home']);
		}
	}