<div class='col-sm-12'>
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
			<fieldset class='col-sm-12'>
				<legend>Classificação Mercadológica</legend>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Grupo', [
							'options' => [
								$produto->cod_grupo => $produto->cod_grupo
							],
							'class' => 'form-control input-sm',
							'selected' => $produto->cod_grupo,
							'name' => 'cod_grupo'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Subgrupo', [
							'options' => [
								$produto->cod_subgrupo => $produto->cod_subgrupo
							],
							'class' => 'form-control input-sm',
							'selected' => $produto->cod_subgrupo,
							'name' => 'cod_subgrupo'
						]) 
					?>
				</div>
			</fieldset>
			<fieldset class='col-sm-12'>
				<legend>Dados Cadastrais</legend>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('Código de barras', [
							'placeholder' => 'EX: FRUTAS E VERDURAS LTDA',
							'class' => 'form-control text-uppercase input-sm',
							'value' => $produto->cod_produto,
							'maxlength' => 14,
							'required' => true,
							'name' => 'cod_produto'
						]) 
					?>
				</div>
				<div class='form-group col-md-6 col-sm-8'>
					<?= $this->Form->input('Descrição', [
							'placeholder' => 'EX: CREME DENTAL 75G',
							'class' => 'form-control text-uppercase input-sm',
							'value' => $produto->descricao,
							'maxlength' => 40,
							'required' => true,
							'name' => 'descricao'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Unidade de Medida', [
							'options' => array_column($unidades, 'cod', 'descricao'),
							'class' => 'form-control input-sm',
							'selected' => $produto->unidade,
							'name' => 'unidade'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Balança', [
							'options' => ['SIM' => 'S', 'NÃO' => 'N'],
							'class' => 'form-control input-sm',
							'selected' => $produto->balanca,
							'name' => 'balanca'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Fabricação Própria', [
							'options' => ['SIM' => 'P', 'NÃO' => 'T'],
							'class' => 'form-control input-sm',
							'selected' => $produto->fabricacao,
							'name' => 'fabricacao'
						]) 
					?>
				</div>
			</fieldset>
			<fieldset class='col-sm-12'>
				<legend>Preço</legend>
				<fieldset class='col-sm-12'>
					<legend>Varejo</legend>
					<div class='form-group col-md-2 col-sm-3'>
						<?= $this->Form->input('Preço Compra', [
								'placeholder' => 'EX: 10,50',
								'class' => 'form-control money input-sm',
								'value' => $produto->compra,
								'maxlength' => 10,
								'required' => true,
								'name' => 'compra'
							]) 
						?>
					</div>
					<div class='form-group col-md-2 col-sm-3'>
						<?= $this->Form->input('Markup', [
								'placeholder' => 'EX: 40.00',
								'class' => 'form-control input-sm',
								'value' => $produto->markup,
								'maxlength' => 7,
								'required' => true,
								'name' => 'markup'
							]) 
						?>
					</div>
					<div class='form-group col-md-2 col-sm-3'>
						<?= $this->Form->input('Preço Sugerido', [
								'class' => 'form-control money input-sm',
								'value' => '0,00',
								'disabled' => true
							]) 
						?>
					</div>
					<div class='form-group col-md-2 col-sm-3'>
						<?= $this->Form->input('Preço Varejo', [
								'placeholder' => 'EX: 15,55',
								'class' => 'form-control money input-sm',
								'value' => $produto->venda,
								'maxlength' => 10,
								'required' => true,
								'name' => 'venda'
							]) 
						?>
					</div>	
				</fieldset>
				<fieldset class='col-sm-12'>
					<legend>Atacarejo</legend>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->select('Tipo Multiplicador', [
								'options' => ['MULTIPLO' => 'M', 'A PARTIR' => 'A'],
								'class' => 'form-control input-sm',
								'selected' => $produto->tipo_venda_volume,
								'name' => 'tipo_venda_volume'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Quantidade Atacarejo', [
								'placeholder' => 'EX: 5',
								'class' => 'form-control input-sm',
								'value' => $produto->qtd_vol,
								'type' => 'number',
								'maxlength' => 6,
								'required' => true,
								'name' => 'qtd_vol'
							]) 
						?>
					</div>	
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Preço Atacarejo', [
								'placeholder' => 'EX: 12,99',
								'class' => 'form-control money input-sm',
								'value' => $produto->preco_vol,
								'maxlength' => 10,
								'required' => true,
								'name' => 'preco_vol'
							]) 
						?>
					</div>	

					<!-- 
					cod_produto
					data_inicio_prom
					data_final_prom
					preco_prom
					descricao_promocao
					cod_ncm
					cstpc
					cstpc_entrada
					ali_pis_debito
					ali_cofins_debito
					st
					cfop_in
					cest
					icms_in
					icms_out 
					-->
				</fieldset>
			</fieldset>
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
