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

		public function buscaCest(int $filtro, $valor)
		{	
			$cest = $this->find(['descricao'])
				->distinct('cest')->as('codigo')
				->limit(60);

			switch ($filtro) {
				case 1:
					if (is_numeric($valor)) {
						if (strlen($valor) < 7) {
							$cest->where(['cest like ' => $valor.'%']);
						}
						else {
							$cest->where(['cest like ' => $valor]);
						}
						return $cest->orderBy(['cest'])->fetch('all');
					}
					break;
				case 2:
					if (is_string($valor)) {
						return $cest->where(['descricao like ' => $valor.'%'])
							->orderBy(['descricao'])
							->fetch('all');
					}
					break;
			}
			return false;
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