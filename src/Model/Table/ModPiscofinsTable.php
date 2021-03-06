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

		public function buscaCstpc(int $filtro, $valor)
		{	
			$cstpc = $this->find(['descricao'])
				->distinct('codigo')->as('codigo')
				->limit(60);

			switch ($filtro) {
				case 1:
					if (is_numeric($valor)) {
						if (strlen($valor) < 4) {
							$cstpc->where(['codigo like ' => $valor.'%']);
						}
						else {
							$cstpc->where(['codigo like ' => $valor]);
						}
						return $cstpc->orderBy(['codigo'])->fetch('all');
					}
					break;
				case 2:
					if (is_string($valor)) {
						return $cstpc->where(['descricao like ' => $valor.'%'])
							->orderBy(['descricao'])
							->fetch('all');
					}
					break;
			}
			return false;
		}

		public function getCstpcDescricao(string $codigo)
		{
			return $this->find(['descricao'])
				->where(['codigo =' => $codigo])
				->fetch('class');
		}

		public function getCstpcRef(string $codigo)
		{
			return $this->find(['referencia'])
				->where(['codigo =' => $codigo])
				->fetch('class');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('codigo')->notEmpty()->int()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(150);
			$validator->addRule('referencia')->empty()->int()->size(4);

			return $validator;
		}
	}