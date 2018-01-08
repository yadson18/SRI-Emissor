<?php 
	namespace App\Controller;

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
			$auth = $this->Auth->getUser();

			$this->setTitle('Home');
			$this->setViewVars([
				'authName' => $auth->nome,
				'authRazao' => $auth->cadastro->razao,
				'authCnpj' => $auth->cadastro->cnpj
			]);	
		}
	}