<?php 
	namespace App\Controller;

	class StController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function find()
		{
			if ($this->request->is('POST')) {
				$data = array_map('removeSpecialChars', $this->request->getData());

				if (!empty($data['filtro']) && is_numeric($data['busca']) && 
					$data['busca'] >= 0 || !empty($data['busca'])
				) {
					$st = $this->St->buscaSt($data['filtro'], $data['busca']);

					if (!empty($st)) {
						$this->Ajax->response('st', [
							'status' => 'success',
							'data' => $st
						]);
					}
					else {
						$this->Ajax->response('st', [
							'status' => 'error',
							'message' => 'Desculpe, nada foi encontrado.'
						]);
					}
				}
				else {
					$this->Ajax->response('st', [
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