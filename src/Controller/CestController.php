<?php 
	namespace App\Controller;

	class CestController extends AppController
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
					$cest = $this->Cest->buscaCest($data['filtro'], $data['busca']);

					if (!empty($cest)) {
						$this->Ajax->response('cest', [
							'status' => 'success',
							'data' => $cest
						]);
					}
					else {
						$this->Ajax->response('cest', [
							'status' => 'error',
							'message' => 'Desculpe, nada foi encontrado.'
						]);
					}
				}
				else {
					$this->Ajax->response('cest', [
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