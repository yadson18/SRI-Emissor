<?php 
	namespace App\Controller;

	class CfopController extends AppController
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
					$cfop = $this->Cfop->buscaCfop($data['filtro'], $data['busca']);

					if (!empty($cfop)) {
						$this->Ajax->response('cfop', [
							'status' => 'success',
							'data' => $cfop
						]);
					}
					else {
						$this->Ajax->response('cfop', [
							'status' => 'error',
							'message' => 'Desculpe, nada foi encontrado.'
						]);
					}
				}
				else {
					$this->Ajax->response('cfop', [
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