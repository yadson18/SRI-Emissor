<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class ModPiscofinsTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('MOD_PISCOFINS');

			$this->setPrimaryKey('codigo');

			$this->setBelongsTo('', []);
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('codigo')->notEmpty()->int()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(150);
			$validator->addRule('referencia')->empty()->int()->size(4);

			return $validator;
		}
	}