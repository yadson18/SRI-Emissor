<?php 
	namespace App\Controller;

	class ContratoController extends AppController
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