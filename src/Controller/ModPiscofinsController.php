<?php 
	namespace App\Controller;

	class ModPiscofinsController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function find()
		{
			if ($this->request->is('POST')) {
				$data = array_map('removeSpecialChars', $this->request->getData());

				if (!empty($data['filtro']) && !empty($data['busca'])) {
					$cstpc = $this->ModPiscofins->buscaCstpc($data['filtro'], $data['busca']);

					if (!empty($cstpc)) {
						$this->Ajax->response('cstpc', [
							'status' => 'success',
							'data' => $cstpc
						]);
					}
					else {
						$this->Ajax->response('cstpc', [
							'status' => 'error',
							'message' => 'Desculpe, nada foi encontrado.'
						]);
					}
				}
				else {
					$this->Ajax->response('cstpc', [
						'status' => 'error',
						'message' => 'Por favor, verifique se os dados foram digitados corretamente.'
					]);
				}
			}
			else {
				return $this->redirect('default');
			}	
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['find']);
		}
	}