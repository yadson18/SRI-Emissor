<?php 
	namespace Simple\View;

	use Simple\View\Components\Html;
	use Simple\View\Components\Form;

	class View
	{
		const LAYOUT = TEMPLATE . 'Layout' . DS;

		const DEFAULT = 'default' . View::EXT;
		
		const ERROR = 'error' . View::EXT;
		
		const AJAX = 'ajax' . View::EXT;
		
		const EXT = '.php';

		private $contentType;

		private $templatePath;

		private $controllerName;

		private $template;

		private $title;

		private $viewVars;

		public function __construct()
		{
			$this->Html = new Html();
			$this->Form = new Form();
		}

		public function setComponents(array $components)
		{
			foreach ($components as $componentName => $instance) {
				$this->$componentName = $instance;
			}
		}

		public function fetch(string $dataIndex)
		{
			switch ($dataIndex) {
				case 'title': 
					return $this->getTitle(); 
				break;
				case 'controllerName': 
					return $this->getControllerName(); 
				break;
				case 'viewName': 
					return $this->getTemplate(); 
				break;
				case 'appName': 
					return \Simple\Application\Application::getAppName(); 
				break;
				case 'content': 
					return $this->getTemplateContent(
						$this->getTemplatePath() . $this->getTemplate() . View::EXT
					);
				break;
			}
		}

		public function setContentType(string $contentType)
		{
			$this->contentType = $contentType;
		}

		protected function getContentType()
		{
			return $this->contentType;
		}

		public function setTemplatePath(string $templatePath){
			$this->templatePath = $templatePath;
		}

		protected function getTemplatePath(){
			return $this->templatePath;
		}

		public function setTemplate(string $template){
			$this->template = $template;
		}

		protected function getTemplate(){
			return $this->template;
		}

		protected function canBeRender(string $file)
		{
			if (file_exists($file)) {
				return true;
			}
			return false;
		}

		protected function getTemplateContent()
		{
			ob_start();
			
			if ($this->canBeRender($this->getTemplatePath() . $this->getTemplate() . View::EXT)) {
				if (!empty($this->getViewVars())) {
					foreach ($this->getViewVars() as $variable => $value) {
						if (is_string($variable)) {
							$$variable = $value;
						}
					}
				}
				require_once $this->getTemplatePath() . $this->getTemplate() . View::EXT;
			}
			
			ob_end_flush();
			return ob_get_clean();
		}

		protected function getLayoutContent(string $layout)
		{
			ob_start();

			if ($this->canBeRender(View::LAYOUT . $layout)) {
				require_once View::LAYOUT . $layout;
			}

			ob_end_flush();
			return ob_get_clean();
		}

		public function render()
		{
			switch ($this->getContentType()) {
				case 'ajax':
					echo $this->getLayoutContent(View::AJAX);
				break;
				case 'default':
					echo $this->getLayoutContent(View::DEFAULT);
				break;
				default:
					echo $this->getLayoutContent(View::ERROR);
				break;
			}
		}

		public function setTitle(string $title)
		{
			$this->title = $title;
		}

		protected function getTitle()
		{
			if (isset($this->title)) {
				return $this->title;
			}
			return $this->getTemplate();
		}

		public function setViewVars(array $viewVars)
		{
			$this->viewVars = $viewVars;
		}

		protected function getViewVars()
		{
			return $this->viewVars;
		}

		public function setControllerName(string $controller){
			$this->controllerName = $controller;
		}

		protected function getControllerName(){
			return $this->controllerName;
		}
	}