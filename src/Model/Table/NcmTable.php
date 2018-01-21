<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class NcmTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('NCM');

			$this->setPrimaryKey('ncm');

			$this->setBelongsTo('', []);
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('ncm')->notEmpty()->string()->size(8);
			$validator->addRule('descricao')->empty()->string()->size(2000);
			$validator->addRule('tec')->empty()->int()->size(4);
			$validator->addRule('bkbit')->empty()->string()->size(10);
			$validator->addRule('excecoes')->empty()->string()->size(10);
			$validator->addRule('icms_in')->empty()->int()->size(2);
			$validator->addRule('icms_out')->empty()->int()->size(2);
			$validator->addRule('cfop_in')->empty()->string()->size(4);
			$validator->addRule('cfop_out')->empty()->string()->size(4);
			$validator->addRule('st')->empty()->string()->size(4);
			$validator->addRule('nat_receita')->empty()->string()->size(4);
			$validator->addRule('cstpc')->empty()->int()->size(4);
			$validator->addRule('cstpc_entrada')->empty()->int()->size(4);
			$validator->addRule('percpiscred')->empty()->int()->size(4);
			$validator->addRule('perccofinscred')->empty()->int()->size(4);
			$validator->addRule('percpisdeb')->empty()->int()->size(4);
			$validator->addRule('perccofinsdeb')->empty()->int()->size(4);
			$validator->addRule('ativo')->notEmpty()->string()->size(1);
			$validator->addRule('val_ibpt')->empty()->int()->size(8);
			$validator->addRule('nat_receitasec')->empty()->string()->size(4);
			$validator->addRule('cest')->empty()->string()->size(7);
			$validator->addRule('desc_cest')->empty()->string()->size(8);

			return $validator;
		}
	}