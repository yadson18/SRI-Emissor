<?php 
	namespace App\Controller;

	class SubgrupoProdController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}
 
		public function getSubgrupos()
		{
			if ($this->request->is('POST')) {
				$data = $this->request->getData();

				if (isset($data['codGrupo'])) {
					$this->Ajax->response('subgrupos', [
						'status' => 'success',
						'data' => $this->SubgrupoProd->getSubgrupos($data['codGrupo'])
					]);
				}
				else {
					$this->Ajax->response('subgrupos', [
						'status' => 'error',
						'data' => 'Nenhum subgrupo encontrado, grupo inexistente.' 
					]);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['getSubgrupos']);
		}
	}