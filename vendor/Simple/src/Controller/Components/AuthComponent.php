<?php 
	namespace Simple\Controller\Components;

	use Simple\Auth\Auth;
	
	class AuthComponent extends Auth
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->initialize([
				'login' => [
					'controller' => 'Page', 
					'view' => 'home'
				],
				'logout' => [
					'controller' => 'Page', 
					'view' => 'index'
				]
			]);
		}

		public function isAuthorized()
		{
			return $this->allow(['home', 'logout']);
		}
	}