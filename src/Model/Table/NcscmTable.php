<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class NcscmTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('ncm nc, cest c, st s, cfop cf, mod_piscofins m');

			$this->setPrimaryKey('');

			$this->setBelongsTo('', []);
		}

		public function getProductNcscm($produto)
		{
			$ncscm = $this->find([
					'nc.ncm as ncm_cod', 'nc.descricao as ncm_descricao',
					'm.codigo as cstpc_cod', 'm.referencia as cstpc_entrada_cod',
					'm.descricao as cstpc_descricao',
					's.cod_st as st_cod', 's.descricao as st_descricao',
					'cf.cfop as cfop_cod', 'cf.descricao as cfop_descricao',
					'c.cest as cest_cod', 'c.descricao as cest_descricao'
				])
				->where([
					'nc.ncm =' => $produto->cod_ncm, 'and', 
					'm.codigo =' => $produto->cstpc, 'and',
					's.cod_st =' => $produto->st, 'and',
					'cf.cfop =' => $produto->cfop_in, 'and', 
					'c.cest =' => $produto->cest
				])
				->limit(1)
				->fetch('all');

			if (!empty($ncscm)) {
				$produto = $this->patchEntity($produto, array_shift($ncscm));
				unset(
					$produto->cod_ncm, $produto->cstpc, 
					$produto->cstpc_entrada, $produto->st, 
					$produto->cfop_in, $produto->cest
				);

				return $produto;
			}
		}

		protected function defaultValidator(Validator $validator)
		{
			return $validator;
		}
	}