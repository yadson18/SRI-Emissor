<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class CestTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CEST');

			$this->setPrimaryKey('ncm');

			$this->setBelongsTo('', []);
		}

		public function getCestDescricao(string $cest)
		{
			return $this->find(['descricao'])
				->where(['cest =' => $cest])
				->fetch('class');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq')->notEmpty()->int()->size(4);
			$validator->addRule('ncm')->notEmpty()->string()->size(25);
			$validator->addRule('descricao')->notEmpty()->string()->size(1024);
			$validator->addRule('cest')->notEmpty()->string()->size(7);

			return $validator;
		}
	}