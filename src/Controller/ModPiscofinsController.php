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
				$dados = array_map('removeSpecialChars', $this->request->getData());

				if (!empty($dados['filtro']) && is_numeric($dados['busca']) && 
					$dados['busca'] >= 0 || !empty($dados['busca'])
				) {
					$cstpc = $this->ModPiscofins->buscaCstpc($dados['filtro'], $dados['busca']);

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