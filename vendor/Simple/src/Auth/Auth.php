<?php 
	namespace Simple\Auth;

	use Simple\ORM\Interfaces\EntityInterface;
	use Simple\Session\Session;

	abstract class Auth {
		private $session;

		public function __construct()
		{
			$this->session = new Session();
		}

		public function setUser(EntityInterface $entity)
		{
			$this->session->setData('Auth', $entity);
		}

		public function unsetUser()
		{
			$this->session->removeData('Auth');
		}	

		public function destroy()
		{
			$this->session->destroy();
		}

		public function getUser(string $index = null)
		{
			if (empty($index)) {
				return $this->session->getData('Auth');
			}
			else if (isset($this->session->getData('Auth')->$index)) {
				return $this->session->getData('Auth')->$index;
			}
		}

		public function loginRedirect()
		{
			if (isset($this->configs['login'])) {
				return $this->configs['login'];
			}
		}

		public function logoutRedirect()
		{
			if (isset($this->configs['logout'])) {
				return $this->configs['logout'];
			}
		}

		protected function initialize(array $configs)
		{
			$this->configs = $configs;
		}

		protected function allow(array $methods = [])
		{
			return $methods;
		}
	}