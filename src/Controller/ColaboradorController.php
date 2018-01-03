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
				$colaborador = $this->Colaborador->patchEntity(
					$colaborador, $this->request->getData()
				);

				$this->Colaborador->login($colaborador);
			}
		}
	}