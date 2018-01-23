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
						'subgrupos' => $this->SubgrupoProd->getSubgrupos($data['codGrupo'])
					]);
				}
			}
			else {
				return $this->redirect(['controller' => 'Produto', 'view' => 'index']);
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['getSubgrupos']);
		}
	}