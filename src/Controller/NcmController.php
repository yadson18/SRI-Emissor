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
				$data = array_map('sanitize', $this->request->getData());
				$resultado = null;

				if (!empty($data['search']) && !empty($data['filter'])) {
					$resultado = $this->Ncm->find(['descricao'])
						->distinct('ncm')->as('ncm')
						->orderBy(['descricao'])
						->limit(60);
					
					if ($data['filter'] === 'codigo') {
						$resultado->where(['ncm like' => $data['search'] . '%']);
					}
					else if ($data['filter'] === 'descricao') {
						$resultado->where(['descricao like' => $data['search'] . '%']);
					}
					$resultado = $resultado->fetch('all');

					if (!empty($resultado)) {
						$this->Ajax->response('ncm', [
							'status' => 'success',
							'data' => $resultado
						]);
					}
					else {
						$this->Ajax->response('ncm', [
							'status' => 'error',
							'message' => 'Desculpe, nada foi encontrado.'
						]);
					}
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