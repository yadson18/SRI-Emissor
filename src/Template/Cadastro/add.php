<div class='col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1'>
	<?= $this->Form->start('', ['id' => 'form-add']) ?>
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
						'class' => 'form-control input-sm cpfMask',
						'placeholder' => 'EX: 095.726.241-80',
						'name' => 'cnpj'
					]) 
				?>	
			</div>
			<div class='form-group col-sm-6 hidden estadual'>
				<?= $this->Form->input('Inscrição Estadual', [
						'placeholder' => 'EX: ISENTO', 
						'required' => false,
						'maxlength' => 20,
						'name' => false
					]) 
				?>
			</div>  
		</div>
	</div>
	<div class='form-group col-sm-6'>
		<?= $this->Form->input('Razão Social', [
				'placeholder' => 'EX: FRUTAS E VERDURAS LTDA',
				'maxlength' => 60,
				'name' => 'razao'
			]) 
		?>
	</div>
	<div class='form-group col-sm-6'>
		<?= $this->Form->input('Fantasia', [
				'placeholder' => 'EX: FRUTAS E VERDURAS',
				'maxlength' => 40
			]) 
		?>
	</div>
	<div class='form-group col-sm-4'>
		<?= $this->Form->input('CEP', [
				'class' => 'form-control input-sm cepMask',
				'placeholder' => 'EX: 50000-000'
			]) 
		?>	
	</div>
	<div class='form-group col-sm-3'>
		<?= $this->Form->select('Estado', array_column(
				$estados, 'sigla', 'sigla'
			)) 
		?>
	</div>
	<div class='form-group col-sm-5'>	
		<?= $this->Form->select('Cidade', array_column(
				$municipios, 'nome_municipio', 'nome_municipio'
			)) 
		?>
	</div>
	<div class='form-group col-md-5 col-sm-6'>	
		<?= $this->Form->input('Bairro', [
				'placeholder' => 'EX: CENTRO',
				'maxlength' => 30
			]) 
		?>
	</div>
	<div class='form-group col-md-5 col-sm-6'>	
		<?= $this->Form->input('Endereço', [
				'placeholder' => 'EX: RUA CARLOS AFONSO',
				'maxlength' => 40
			]) 
		?>
	</div>
	<div class='form-group col-md-2 col-sm-4'>	
		<?= $this->Form->input('Número', [
				'placeholder' => 'EX: S/N',
				'name' => 'nrend1',
				'maxlength' => 12
			]) 
		?> 
	</div>
	<div class='form-group col-md-5 col-sm-8'>	 
		<?= $this->Form->input('Complemento', [
				'placeholder' => 'EX: EMPRESARIAL ABC, 22',
				'name' => 'complementar',
				'maxlength' => 40
			]) 
		?>
	</div>
	<div class='form-group col-sm-7'>	
		<?= $this->Form->select('Código de Regime Tributário', [
				'SIMPLES NACIONAL - EXCESSO DE SUBLIMITE DA RECEITA BRUTA' => 2,
				'SIMPLES NACIONAL' => 1,
				'REGIME NORMAL' => 3
			], [
				'name' => 'cod_reg_trib'
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
