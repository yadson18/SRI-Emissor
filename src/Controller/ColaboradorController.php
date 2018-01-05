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
				$result = $this->Colaborador->login($this->Colaborador->patchEntity(
					$colaborador, $this->request->getData()
				));

				if ($result['status'] === 'success') {
					$this->Auth->setUser($result['user']);

					$this->Ajax->response('login', [
						'redirect' => $this->Auth->loginRedirect()
					]);
				}
				else {
					$this->Ajax->response('login', $result);
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
	}