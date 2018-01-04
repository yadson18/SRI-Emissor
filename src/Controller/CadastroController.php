<?php 
	namespace App\Controller;

	class CadastroController extends AppController
	{
		public function isAuthorized(string $method)
		{
			return $this->alowedMethods($method, []);
		}
	}