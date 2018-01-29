<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class NcsccTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('NCM nc');

			$this->setPrimaryKey('');

			$this->setBelongsTo('', []);
		}

		public function validaNCSCC($ncm, $cstpc, $st, $cfop, $cest)
		{
			$ncscc = $this->find([
					'CASE WHEN (nc.DESCRICAO IS NULL) THEN 0 ELSE 1 END AS NCM',
					'CASE WHEN (mp.DESCRICAO IS NULL) THEN 0 ELSE 1 END AS CSTPC',
					'CASE WHEN (st.DESCRICAO IS NULL) THEN 0 ELSE 1 END AS ST',
					'CASE WHEN (cf.DESCRICAO IS NULL) THEN 0 ELSE 1 END AS CFOP'
				])
				->join([
					'LEFT JOIN MOD_PISCOFINS mp ON(mp.CODIGO = ' . $cstpc . ')',
					'LEFT JOIN ST st ON(st.COD_ST = ' . $st . ')',
					'LEFT JOIN CFOP cf ON(cf.CFOP = ' . $cfop . ')'
				]);

			if ($cest !== '0000000') {
				$ncscc->find([
						'CASE WHEN (ce.DESCRICAO IS NULL) THEN 0 ELSE 1 END AS CEST'
					])
					->join(['LEFT JOIN CEST ce ON(ce.CEST = ' . $cest . ')']);
			}
			
			$validador = $ncscc->where(['nc.NCM =' => $ncm])->fetch('all');

			if (!empty($validador)) {
				$campo = array_search(0, array_shift($validador));

				if ($campo) {
					$campo = strtoupper($campo);
					return [
						'status' => 'error',
						'coluna' => $campo,
						'message' => 'Por favor, digite um ' . $campo . ' válido.'
					];
				}
				return ['status' => 'success'];
			}
			return [
				'status' => 'error',
				'coluna' => 'NCM',
				'message' => 'Por favor, digite um NCM válido.'
			];
		}

		protected function defaultValidator(Validator $validator)
		{
			return $validator;
		}
	}