<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class GrupoProdTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('GRUPO_PROD');

			$this->setPrimaryKey('cod_grupo');

			$this->setBelongsTo('', []);
		}

		public function getGrupos()
		{
			return $this->find(['cod_grupo', 'descricao'])->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('empresa')->notEmpty()->int()->size(4);
			$validator->addRule('cod_grupo')->notEmpty()->int()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(20);

			return $validator;
		}
	}