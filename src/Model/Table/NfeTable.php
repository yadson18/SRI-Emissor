<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class NfeTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('NFE');

			$this->setPrimaryKey('nfe_b_cnf');

			$this->setBelongsTo('', []);
		}

		public function quantidadeEmitidas() 
		{
			$dataDeHoje = date("'". 'd.m.Y' ."'");
			
			return $this->find([])
				->sum('case when nfe_b_demit = '. $dataDeHoje .' then 1 else 0 end')->as('hoje')
				->count('nfe_b_cnf')->as('total')
				->where(['nfe_status =' => '03'])
				->fetch('class');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('nfe_b_cnf')->notEmpty()->int()->size(4);
			$validator->addRule('nfe_a_versao')->empty()->string()->size(4);
			$validator->addRule('nfe_a_id')->empty()->string()->size(50);
			$validator->addRule('nfe_b_cuf')->empty()->string()->size(2);
			$validator->addRule('nfe_b_natop')->empty()->string()->size(150);
			$validator->addRule('nfe_b_indpag')->empty()->int()->size(4);
			$validator->addRule('nfe_b_mod')->empty()->string()->size(2);
			$validator->addRule('nfe_b_serie')->empty()->string()->size(3);
			$validator->addRule('nfe_b_nnf')->empty()->int()->size(4);
			$validator->addRule('nfe_b_demit')->empty()->string()->size(4);
			$validator->addRule('nfe_b_dsaient')->empty()->string()->size(4);
			$validator->addRule('nfe_b_tpnf')->empty()->int()->size(4);
			$validator->addRule('nfe_b_cmunfg')->empty()->string()->size(7);
			$validator->addRule('nfe_b_tpimp')->empty()->string()->size(1);
			$validator->addRule('nfe_b_emis')->empty()->string()->size(1);
			$validator->addRule('nfe_b_cdv')->empty()->string()->size(1);
			$validator->addRule('nfe_b_tbamb')->empty()->string()->size(1);
			$validator->addRule('nfe_b_finnfe')->empty()->string()->size(1);
			$validator->addRule('nfe_b_procemit')->empty()->string()->size(1);
			$validator->addRule('nfe_b_verproc')->empty()->string()->size(20);
			$validator->addRule('nfe_c_codemitente')->empty()->int()->size(4);
			$validator->addRule('nfe_c_coddestinatario')->empty()->int()->size(4);
			$validator->addRule('nfe_w_vbc')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vicms')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vbcst')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vst')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vprod')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vfrete')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vseg')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vdesc')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vii')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vipi')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vpis')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vcofins')->empty()->int()->size(8);
			$validator->addRule('nfe_w_voutro')->empty()->int()->size(8);
			$validator->addRule('nfe_w_vnf')->empty()->int()->size(8);
			$validator->addRule('nfe_x_modfrete')->empty()->string()->size(1);
			$validator->addRule('nfe_x_cod_transp')->empty()->int()->size(4);
			$validator->addRule('nfe_status')->notEmpty()->string()->size(2);
			$validator->addRule('nfe_protocolo_autorizador')->empty()->string()->size(100);
			$validator->addRule('nfe_data_protocolo')->empty()->string()->size(4);
			$validator->addRule('nfe_hora_protocolo')->empty()->string()->size(4);
			$validator->addRule('nfe_x_placa')->empty()->string()->size(15);
			$validator->addRule('nfe_x_ufpl')->empty()->string()->size(2);
			$validator->addRule('nfe_x_qvol')->empty()->int()->size(4);
			$validator->addRule('nfe_x_esp')->empty()->string()->size(60);
			$validator->addRule('nfe_x_marca')->empty()->string()->size(60);
			$validator->addRule('nfe_x_nvol')->empty()->string()->size(60);
			$validator->addRule('nfe_x_pesol')->empty()->int()->size(8);
			$validator->addRule('nfe_x_pesob')->empty()->int()->size(8);
			$validator->addRule('nfe_z_inffisco')->empty()->string()->size(255);
			$validator->addRule('nfe_z_infcpl')->empty()->string()->size(4096);
			$validator->addRule('nfe_origem')->notEmpty()->int()->size(4);
			$validator->addRule('nfe_z_horajust')->empty()->string()->size(20);
			$validator->addRule('nfe_z_just')->empty()->string()->size(60);
			$validator->addRule('nfe_b_final')->notEmpty()->int()->size(4);
			$validator->addRule('nfe_entregue')->notEmpty()->int()->size(4);

			return $validator;
		}
	}