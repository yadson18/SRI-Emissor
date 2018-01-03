<?php 
	namespace Simple\Controller\Components;

	use Simple\ORM\Interfaces\EntityInterface;
	use Simple\Session\Session;

	class AuthComponent
	{
		private $session;

		public function __construct()
		{
			$this->session = new Session();
		}

		public function set(EntityInterface $entity)
		{
			$this->session->setData('Auth', $entity);
		}

		public function unset()
		{
			$this->session->removeData('Auth');
		}	

		public function get(string $index = null)
		{
			if (empty($index)) {
				return $this->session->getData('Auth');
			}
			else if (isset($this->session->getData('Auth')->$index)) {
				return $this->session->getData('Auth')->$index;
			}
		}
	}