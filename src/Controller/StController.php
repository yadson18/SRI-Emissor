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
				$dados = array_map('removeSpecialChars', $this->request->getData());

				if (!empty($dados['filtro']) && is_numeric($dados['busca']) && 
					$dados['busca'] >= 0 || !empty($dados['busca'])
				) {
					$st = $this->St->buscaSt($dados['filtro'], $dados['busca']);

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