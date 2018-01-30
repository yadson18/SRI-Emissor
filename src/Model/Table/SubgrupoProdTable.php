<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class SubgrupoProdTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('SUBGRUPO_PROD');

			$this->setPrimaryKey('cod_grupo');

			$this->setBelongsTo('', []);
		}

		public function getSubgrupos(int $cod_grupo)
		{
			$subgrupos = $this->find(['cod_subgrupo', 'descricao'])
				->where(['cod_grupo =' => $cod_grupo])
				->orderBy(['cod_subgrupo'])
				->fetch('all');

			return array_merge([
					['cod_subgrupo' => 0, 'descricao' => '-- SEM SUBGRUPO --']
			], $subgrupos);
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('empresa')->notEmpty()->int()->size(4);
			$validator->addRule('cod_grupo')->notEmpty()->int()->size(4);
			$validator->addRule('cod_subgrupo')->notEmpty()->int()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(40);
			$validator->addRule('markup')->notEmpty()->int()->size(8);

			return $validator;
		}
	}