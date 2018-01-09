<?php 
	namespace App\Controller;

	class CadastroController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function index()
		{
			$this->setTitle('Listagem');
			$this->setViewVars([
				'usuarioNome' => $this->nomeUsuarioLogado(),
				'cadastros' => $this->Cadastro->listarAtivos()
			]);
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index']);
		}
	}