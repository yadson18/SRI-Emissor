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

		public function buscaSt(int $filtro, $valor)
		{	
			$st = $this->find(['descricao'])
				->distinct('cod_st')->as('codigo')
				->limit(60);

			switch ($filtro) {
				case 1:
					if (is_numeric($valor)) {
						if (strlen($valor) < 4) {
							$st->where(['cod_st like ' => $valor.'%']);
						}
						else {
							$st->where(['cod_st like ' => $valor]);
						}
						return $st->orderBy(['cod_st'])->fetch('all');
					}
					break;
				case 2:
					if (is_string($valor)) {
						return $st->where(['descricao like ' => $valor.'%'])
							->orderBy(['descricao'])
							->fetch('all');
					}
					break;
			}
			return false;
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