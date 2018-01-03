<?php 
	namespace App\Controller;

	use Simple\Controller\Controller;
	use Simple\Http\Request;
	use Simple\View\View;

	abstract class AppController extends Controller
	{
		/**
		 * initialize Method.
		 *
		 * @param 
		 *		Simple\Http\Request $request - server request.
		 *		Simple\View\View $view - current view controller.
		 * @return 
		 *		null
		 */
		public function initialize(Request $request, View $view)
		{
			parent::initialize($request, $view);

			$this->loadComponent('Ajax');

			$this->loadComponent('Flash');

			$this->loadComponent('Auth');
		}	

		/**
		 * alowedMethods Method.
		 *
		 * @param 
		 *		string $method - method name to check access authorization.
		 *		array $methods - methods with authorized access.
		 * @return 
		 *		boolean
		 */
		public function alowedMethods(string $method, array $methods)
        {
            if (in_array($method, $methods)) {
                return true;
            }
            return false;
        }
	}