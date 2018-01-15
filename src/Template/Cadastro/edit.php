<div class='col-sm-8 col-sm-offset-2'>
	<?php if($cadastro): ?>
		<?= $this->Form->start([
				'action' => '/Cadastro/edit/' . $cadastro->cod_cadastro,
				'method' => 'POST',
				'id' => 'form-edit'
			]) 
		?>
			<div class='form-header text-center'>
				<h4>Modificar Destinatário</h4>
			</div>
			<div class='col-sm-12 message-box'>
				<?= $this->Flash->showMessage() ?>
			</div>
			<div class='col-sm-12'>
				<div class='row'>
					<div class='form-group col-sm-12' id='breadcrumb'>
						<ul class='nav nav-tabs destinatarie-type'>
							<?php if($cadastroTipo === 'cpf'): ?>
								<li role='breadcrumb-item' class='active'>
									<a href='#' id='CPF'>Pessoa Física</a>
								</li>
								<li role='breadcrumb-item'>
									<a href='#' id='CNPJ'>Pessoa Jurídica</a>
								</li>
							<?php else: ?>
								<li role='breadcrumb-item'>
									<a href='#' id='CPF'>Pessoa Física</a>
								</li>
								<li role='breadcrumb-item' class='active'>
									<a href='#' id='CNPJ'>Pessoa Jurídica</a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
					<div class='form-group col-sm-6'>
						<?= $this->Form->input(strtoupper($cadastroTipo) , [
								'placeholder' => ($cadastroTipo === 'cnpj') 
									? 'EX: 53.965.649/0001-03' 
									: 'EX: 095.726.241-80',
								'class' => $cadastroTipo . 'Mask form-control',
								'value' => $cadastro->cnpj,
								'required' => true,
								'name' => 'cnpj'
							]) 
						?>	
					</div>
					<?php if($cadastroTipo === 'cnpj'): ?>
						<div class='form-group col-sm-6 estadual'>
					<?php else: ?>
						<div class='form-group col-sm-6 estadual hidden'>
					<?php endif; ?>
						<?= $this->Form->input('Inscrição Estadual', [
								'value' => ($cadastro->estadual) 
									? $cadastro->estadual 
									: 'Não Informado',
								'class' => 'form-control text-uppercase',
								'placeholder' => 'EX: ISENTO', 
								'name' => 'estadual',
								'maxlength' => 20,
								'required' => true
							]) 
						?>
					</div>  
				</div>
			</div>
			<div class='form-group col-sm-6'>
				<?= $this->Form->input('Razão Social', [
						'placeholder' => 'EX: FRUTAS E VERDURAS LTDA',
						'class' => 'form-control text-uppercase',
						'value' => $cadastro->razao,
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
						'value' => $cadastro->fantasia,
						'maxlength' => 40,
						'required' => true
					]) 
				?>
			</div>
			<div class='form-group col-sm-4'>
				<?= $this->Form->input('CEP', [
						'class' => 'cepMask form-control',
						'placeholder' => 'EX: 50000-000',
						'value' => $cadastro->cep,
						'required' => true
					]) 
				?>	
			</div>
			<div class='form-group col-sm-3'>
				<?= $this->Form->select('Estado', [
						'options' => arrayToFormOptions($estados),
						'selected' => $cadastro->estado,
						'required' => true
					]) 
				?>
			</div>
			<div class='form-group col-sm-5'>	
				<?= $this->Form->select('Cidade', [
						'options' => arrayToFormOptions($municipios),
						'selected' => $cadastro->cidade,
						'required' => true
					]) 
				?>
			</div>
			<div class='form-group col-md-5 col-sm-6'>	
				<?= $this->Form->input('Bairro', [
						'class' => 'form-control text-uppercase',
						'placeholder' => 'EX: CENTRO',
						'value' => $cadastro->bairro,
						'maxlength' => 30,
						'required' => true
					]) 
				?>
			</div>
			<div class='form-group col-md-5 col-sm-6'>	
				<?= $this->Form->input('Endereço', [
						'class' => 'form-control text-uppercase',
						'placeholder' => 'EX: RUA CARLOS AFONSO',
						'value' => $cadastro->endereco,
						'name' => 'endereco',
						'maxlength' => 40,
						'required' => true
					]) 
				?>
			</div>
			<div class='form-group col-md-2 col-sm-4'>	
				<?= $this->Form->input('Número', [
						'class' => 'form-control text-uppercase',
						'value' => $cadastro->nrend1,
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
						'value' => $cadastro->complementar,
						'name' => 'complementar',
						'maxlength' => 40,
						'required' => true
					]) 
				?>
			</div>
			<div class='form-group col-sm-7'>	
				<?= $this->Form->select('Código de Regime Tributário', [
						'class' => 'form-control text-uppercase',
						'selected' => $cadastro->cod_reg_trib,
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
	<?php else: ?>
		<div class='col-sm-12 text-center data-not-found'>
			<h4>Desculpe, destinatário inexistente, deseja retornar?.</h4>
			<div class='form-group col-sm-4 col-sm-offset-4'>
				<a href='/Cadastro/index' class='btn btn-primary btn-block'>
					<i class='fas fa-angle-double-left'></i> Retornar 
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>
