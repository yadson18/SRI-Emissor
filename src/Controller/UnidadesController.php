<?php 
	namespace App\Controller;

	class UnidadesController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized([]);
		}
	}