<?php 
	namespace App\Controller;

	class %controller_name%Controller extends AppController
	{
		public function isAuthorized(string $method)
		{
			return $this->alowedMethods($method, []);
		}
	}