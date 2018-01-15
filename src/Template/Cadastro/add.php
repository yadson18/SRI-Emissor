<div class='col-sm-8 col-sm-offset-2'>
	<?= $this->Form->start([
			'action' => '/Cadastro/add',
			'method' => 'POST',
			'id' => 'form-add'
		]) 
	?>
	<div class='form-header text-center'>
		<h4>Adicionar Destinatário</h4>
	</div>
	<div class='col-sm-12 message-box'>
		<?= $this->Flash->showMessage() ?>
	</div>
	<div class='col-sm-12'>
		<div class='row'>
			<div class='form-group col-sm-12' id='breadcrumb'>
				<ul class='nav nav-tabs destinatarie-type'>
					<li role='breadcrumb-item' class='active'>
						<a href='#' id='CPF'>Pessoa Física</a>
					</li>
					<li role='breadcrumb-item'>
						<a href='#' id='CNPJ'>Pessoa Jurídica</a>
					</li>
				</ul>
			</div>
			<div class='form-group col-sm-6'>
				<?= $this->Form->input('CPF' , [
						'placeholder' => 'EX: 095.726.241-80',
						'class' => 'cpfMask form-control',
						'required' => true,
						'name' => 'cnpj'
					]) 
				?>	
			</div>
			<div class='form-group col-sm-6 hidden estadual'>
				<?= $this->Form->input('Inscrição Estadual', [
						'class' => 'form-control text-uppercase',
						'placeholder' => 'EX: ISENTO', 
						'required' => 0,
						'maxlength' => 20,
						'name' => ''
					]) 
				?>
			</div>  
		</div>
	</div>
	<div class='form-group col-sm-6'>
		<?= $this->Form->input('Razão Social', [
				'placeholder' => 'EX: FRUTAS E VERDURAS LTDA',
				'class' => 'form-control text-uppercase',
				'maxlength' => 60,
				'required' => true,
				'name' => 'razao'
			]) 
		?>
	</div>
	<div class='form-group col-sm-6'>
		<?= $this->Form->input('Fantasia', [
				'placeholder' => 'EX: FRUTAS E VERDURAS',
				'class' => 'form-control text-uppercase',
				'maxlength' => 40,
				'required' => true
			]) 
		?>
	</div>
	<div class='form-group col-sm-4'>
		<?= $this->Form->input('CEP', [
				'class' => 'cepMask form-control',
				'placeholder' => 'EX: 50000-000',
				'required' => true
			]) 
		?>	
	</div>
	<div class='form-group col-sm-3'>
		<?= $this->Form->select('Estado', [
				'options' => arrayToFormOptions($estados),
				'required' => true
			]) 
		?>
	</div>
	<div class='form-group col-sm-5'>	
		<?= $this->Form->select('Cidade', [
				'options' => arrayToFormOptions($municipios),
				'selected' => $estados[0]['sigla'],
				'required' => true
			]) 
		?>
	</div>
	<div class='form-group col-md-5 col-sm-6'>	
		<?= $this->Form->input('Bairro', [
				'class' => 'form-control text-uppercase',
				'placeholder' => 'EX: CENTRO',
				'maxlength' => 30,
				'required' => true
			]) 
		?>
	</div>
	<div class='form-group col-md-5 col-sm-6'>	
		<?= $this->Form->input('Endereço', [
				'class' => 'form-control text-uppercase',
				'placeholder' => 'EX: RUA CARLOS AFONSO',
				'name' => 'endereco',
				'maxlength' => 40,
				'required' => true
			]) 
		?>
	</div>
	<div class='form-group col-md-2 col-sm-4'>	
		<?= $this->Form->input('Número', [
				'class' => 'form-control text-uppercase',
				'placeholder' => 'EX: S/N',
				'required' => true,
				'maxlength' => 12,
				'name' => 'nrend1'
			]) 
		?> 
	</div>
	<div class='form-group col-md-5 col-sm-8'>	 
		<?= $this->Form->input('Complemento', [
				'placeholder' => 'EX: EMPRESARIAL ABC, 22',
				'class' => 'form-control text-uppercase',
				'name' => 'complementar',
				'maxlength' => 40,
				'required' => true
			]) 
		?>
	</div>
	<div class='form-group col-sm-7'>	
		<?= $this->Form->select('Código de Regime Tributário', [
				'class' => 'form-control text-uppercase',
				'name' => 'cod_reg_trib',
				'options' => [
					'SIMPLES NACIONAL - EXCESSO DE SUBLIMITE DA RECEITA BRUTA' => 2,
					'SIMPLES NACIONAL' => 1,
					'REGIME NORMAL' => 3
				],
				'required' => true
			]) 
		?>
	</div>
	<div class='row'>
		<div class='col-sm-12'>
			<div class='form-group col-sm-5'>
				<a href='/Cadastro/index' class='btn btn-primary btn-block'>
					<i class='fas fa-angle-double-left'></i> Retornar
				</a>
			</div>
			<div class='form-group col-sm-7'>
				<button class='btn btn-success btn-block'>
					Salvar <i class='fas fa-save'></i>
				</button>
			</div>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>