<?php 
	namespace App\Controller;

	class NcmController extends AppController
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
					$ncm = $this->Ncm->buscaNcm($data['filtro'], $data['busca']);

					if (!empty($ncm)) {
						$this->Ajax->response('ncm', [
							'status' => 'success',
							'data' => $ncm
						]);
					}
					else {
						$this->Ajax->response('ncm', [
							'status' => 'error',
							'message' => 'Desculpe, nada foi encontrado.'
						]);
					}
				}
				else {
					$this->Ajax->response('ncm', [
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