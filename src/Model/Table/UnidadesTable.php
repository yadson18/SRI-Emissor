<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class UnidadesTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH2');

			$this->setTable('UNIDADES');

			$this->setPrimaryKey('cod');

			$this->setBelongsTo('', []);
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('cod')->notEmpty()->string()->size(6);
			$validator->addRule('descricao')->empty()->string()->size(50);

			return $validator;
		}
	}