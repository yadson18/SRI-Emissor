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
			$produto = TableRegistry::get('Produto');
			$usuario = $this->Auth->getUser();
			$nfe = TableRegistry::get('Nfe');

			$this->setViewVars([
				'produtosCadastrados' => $produto->quantidadeCadastrados(),
				'usuarioRazao' => $usuario->cadastro->razao,
				'nfeEmitidas' => $nfe->quantidadeEmitidas(),
				'usuarioCnpj' => $usuario->cadastro->cnpj,
				'usuarioNome' => $usuario->nome
			]);	
			$this->setTitle('Home');
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['home']);
		}
	}