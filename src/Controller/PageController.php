<?php 
	namespace App\Controller;

	class PageController extends AppController
	{
		public function isAuthorized(string $method)
		{
			return $this->alowedMethods($method, ['index', 'home']);
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