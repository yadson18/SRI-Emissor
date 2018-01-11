<div class='col-sm-8 col-sm-offset-2'>
	<?php if($cadastro): ?>
		<?= $this->Form->start([
				'action' => '/Cadastro/edit/' . $cadastro->cod_cadastro,
				'method' => 'POST',
				'id' => 'form-edit'
			]) 
		?>
			<?= $this->Flash->showMessage() ?>
			<div class='col-sm-12'>
				<div class='row'>
					<div class='form-group col-sm-6'>
						<?= $this->Form->input(strtoupper($cadastroTipo) , [
								'class' => $cadastroTipo . 'Mask form-control',
								'value' => $cadastro->cnpj,
								'required' => true,
								'name' => 'cnpj'
							]) 
						?>	
					</div>
					<?php if($cadastroTipo === 'cnpj'): ?>
						<div class='form-group col-sm-6'>
							<?= $this->Form->input('Inscrição Estadual', [
									'class' => 'form-control text-uppercase',
									'value' => ($cadastro->estadual) 
										? $cadastro->estadual 
										: 'Não Informado',
									'name' => 'estadual',
									'required' => true
								]) 
							?>
						</div>  
					<?php endif; ?>
				</div>
			</div>
			<div class='form-group col-sm-6'>
				<?= $this->Form->input('Razão Social', [
						'class' => 'form-control text-uppercase',
						'value' => $cadastro->razao,
						'required' => true,
						'name' => 'razao'
					]) 
				?>
			</div>
			<div class='form-group col-sm-6'>
				<?= $this->Form->input('Fantasia', [
						'class' => 'form-control text-uppercase',
						'value' => $cadastro->fantasia,
						'required' => true
					]) 
				?>
			</div>
			<div class='form-group col-sm-4'>
				<?= $this->Form->input('CEP', [
						'class' => 'cepMask form-control',
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
						'value' => $cadastro->bairro,
						'required' => true
					]) 
				?>
			</div>
			<div class='form-group col-md-5 col-sm-6'>	
				<?= $this->Form->input('Endereço', [
						'class' => 'form-control text-uppercase',
						'value' => $cadastro->endereco,
						'name' => 'endereco',
						'required' => true
					]) 
				?>
			</div>
			<div class='form-group col-md-2 col-sm-4'>	
				<?= $this->Form->input('Número', [
						'class' => 'form-control text-uppercase',
						'value' => $cadastro->nrend1,
						'required' => true,
						'name' => 'nrend1'
					]) 
				?> 
			</div>
			<div class='form-group col-md-5 col-sm-8'>	 
				<?= $this->Form->input('Complemento', [
						'class' => 'form-control text-uppercase',
						'value' => $cadastro->complementar,
						'name' => 'complementar',
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
