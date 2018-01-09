<?php 
	namespace App\Controller;

	class ColaboradorController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow(['login']);
		}
		
		public function login()
		{
			$colaborador = $this->Colaborador->newEntity();
			
			if ($this->request->is('POST')) {
				$resultado = $this->Colaborador->login($this->Colaborador->patchEntity(
					$colaborador, $this->request->getData()
				));

				if ($resultado['status'] === 'success') {
					$this->Auth->setUser($resultado['user']);

					$this->Ajax->response('login', [
						'redirect' => $this->Auth->loginRedirect()
					]);
				}
				else {
					$this->Ajax->response('login', $resultado);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function logout()
		{
			$this->Auth->destroy();

			return $this->redirect($this->Auth->logoutRedirect());
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['logout']);
		}
	}