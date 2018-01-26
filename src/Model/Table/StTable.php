<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class StTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('ST');

			$this->setPrimaryKey('cod_st');

			$this->setBelongsTo('', []);
		}

		public function getStDescricao(string $cod_st)
		{
			return $this->find(['descricao'])
				->where(['cod_st =' => $cod_st])
				->fetch('class');
		} 

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('cod_st')->notEmpty()->string()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(150);
			$validator->addRule('origem')->notEmpty()->string()->size(1);

			return $validator;
		}
	}