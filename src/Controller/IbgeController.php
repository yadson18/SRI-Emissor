<?php 
	namespace App\Controller;

	class IbgeController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}
	}