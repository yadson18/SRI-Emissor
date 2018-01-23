<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class CfopTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CFOP');

			$this->setPrimaryKey('cfop');

			$this->setBelongsTo('', []);
		}

		public function getCfopPorCod(string $cfop)
		{
			return $this->find(['cfop', 'descricao'])
				->where(['cfop =' => $cfop])
				->fetch('class');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('cfop')->notEmpty()->string()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(255);
			$validator->addRule('origem')->empty()->string()->size(2);
			$validator->addRule('tipo_movimento')->empty()->int()->size(4);
			$validator->addRule('cfop_corelato')->empty()->string()->size(4);
			$validator->addRule('estoque')->notEmpty()->string()->size(1);
			$validator->addRule('cod_credito_pis')->notEmpty()->string()->size(3);
			$validator->addRule('cop')->empty()->string()->size(4);
			$validator->addRule('usa_piscofins')->notEmpty()->string()->size(1);
			$validator->addRule('ali_pis')->empty()->int()->size(8);
			$validator->addRule('ali_cofins')->empty()->int()->size(8);

			return $validator;
		}
	}