<?php 
	namespace App\Controller;

	class ColaboradorController extends AppController
	{
		public function isAuthorized(string $method)
		{
			return $this->alowedMethods($method, ['login']);
		}
		
		public function login()
		{
			$colaborador = $this->Colaborador->newEntity();

			if ($this->request->is('POST')) {
				$result = $this->Colaborador->login($this->Colaborador->patchEntity(
					$colaborador, $this->request->getData()
				));

				if ($result['status'] === 'success') {
					$this->Auth->set($result['user']);

					$this->Ajax->response('login', ['redirect' => '/Page/home']);
				}
				else {
					$this->Ajax->response('login', $result);
				}
			}
			else {
				return $this->redirect('default');
			}
		}
	}