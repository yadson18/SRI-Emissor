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

		public function listarGrupos(int $quantity = null, int $skipTo = null)
		{
			$grupos = $this->find(['cod_grupo', 'descricao']);

			if (!empty($quantity)) {
				$grupos->limit($quantity);
			}
			if (!empty($skipTo)) {
				$grupos->skip($skipTo);
			}
				
			return $grupos->orderBy(['descricao'])
				->fetch('all');
		}

		public function contarAtivos()
		{
			return $this->find([])
				->count('cod_grupo')->as('quantidade')
				->fetch('class');
		}

		public function getGrupos()
		{
			return $this->find(['cod_grupo', 'descricao'])
				->orderBy(['cod_grupo'])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('empresa')->notEmpty()->int()->size(4);
			$validator->addRule('cod_grupo')->notEmpty()->int()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(20);

			return $validator;
		}
	}