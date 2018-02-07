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
				$dados = array_map('removeSpecialChars', $this->request->getData());

				if (!empty($dados['filtro']) && is_numeric($dados['busca']) && 
					$dados['busca'] >= 0 || !empty($dados['busca'])
				) {
					$cest = $this->Cest->buscaCest($dados['filtro'], $dados['busca']);

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