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
				$dados = $this->request->getData();

				if (isset($dados['cod_grupo']) && is_numeric($dados['cod_grupo'])) {
					$this->Ajax->response('subgrupos', [
						'status' => 'success',
						'data' => $this->SubgrupoProd->getSubgrupos($dados['cod_grupo'])
					]);
				}
				else {
					$this->Ajax->response('subgrupos', [
						'status' => 'error',
						'data' => 'Nenhum subgrupo encontrado, verifique se o código do subgrupo é válido.' 
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