<?php 
	namespace Simple\Controller\Interfaces;

	use Simple\Http\Request;
	use Simple\View\View;

	interface ControllerInterface
	{
		public function initialize(Request $request, View $view);

		public function getComponents();

		public function setTitle(string $title);
		
		public function setViewVars(array $viewVars);

		public function redirect($route);

		public function loadComponent(string $componentName);

		public function initializeTables();

		public function alowedMethods(string $method, array $methods);

		public function isAuthorized(string $method);
	}