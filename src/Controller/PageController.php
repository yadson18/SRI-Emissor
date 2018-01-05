<?php 
	namespace App\Controller;

	class PageController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow(['index']);
		}

		public function index()
		{ 
			$this->setTitle('Início');		
		}

		public function home()
		{
			$this->setTitle('Home');	
		}
	}