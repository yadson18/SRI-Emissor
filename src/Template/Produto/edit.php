<div class='col-sm-8 col-sm-offset-2'>
	<?php if($produto): ?>
		<?= $this->Form->start([
				'action' => '/Produto/edit/' . $produto->cod_interno,
				'method' => 'POST',
				'id' => 'form-edit'
			]) 
		?>
			<div class='form-header text-center'>
				<h4>Modificar Produto</h4>
			</div>
			<div class='col-sm-12 message-box'>
				<?= $this->Flash->showMessage() ?>
			</div>
			<div class='form-group col-sm-6'>
				<?= $this->Form->input('Código de barras', [
						'placeholder' => 'EX: FRUTAS E VERDURAS LTDA',
						'class' => 'form-control text-uppercase',
						'value' => $produto->cod_produto,
						'maxlength' => 60,
						'required' => true,
						'name' => 'cod_produto'
					]) 
				?>
			</div>
			<div class='row'>
				<div class='col-sm-12'>
					<div class='form-group col-sm-5'>
						<a href='/Produto/index' class='btn btn-primary btn-block'>
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
			<h4>Desculpe, produto inexistente, deseja retornar?.</h4>
			<div class='form-group col-sm-4 col-sm-offset-4'>
				<a href='/Cadastro/index' class='btn btn-primary btn-block'>
					<i class='fas fa-angle-double-left'></i> Retornar 
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>
