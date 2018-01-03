<?php 
	namespace App\Controller;

	class PageController extends AppController
	{
		public function isAuthorized(string $method)
		{
			return $this->alowedMethods($method, ['home']);
		}

		public function home()
		{ 
			$this->setTitle('Home');
		}
	}