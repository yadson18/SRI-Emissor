<?php 
	namespace App\Controller;

	class ContratoController extends AppController
	{
		public function isAuthorized(string $method)
		{
			return $this->alowedMethods($method, []);
		}
	}