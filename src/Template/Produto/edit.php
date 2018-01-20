<div class='col-sm-12'>
	<?php if($produto): ?>
		<?= $this->Form->start('', ['id' => 'form-edit']) ?>
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
							$produto->cod_grupo => $produto->cod_grupo
						], [
							'selected' => $produto->cod_grupo,
							'name' => 'cod_grupo'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Subgrupo', [
							$produto->cod_subgrupo => $produto->cod_subgrupo
						], [
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
							'value' => $produto->cod_produto,
							'name' => 'cod_produto',
							'maxlength' => 14
						]) 
					?>
				</div>
				<div class='form-group col-md-6 col-sm-8'>
					<?= $this->Form->input('Descrição', [
							'placeholder' => 'EX: CREME DENTAL 75G',
							'value' => $produto->descricao,
							'maxlength' => 40
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Unidade de Medida', array_column(
							$unidades, 'cod', 'descricao'
						), [
							'selected' => $produto->unidade, 
							'name' => 'unidade'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Balança', [
							'SIM' => 'S', 'NÃO' => 'N'
						], [
							'selected' => $produto->balanca
						])
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Fabricação Própria', [
							'SIM' => 'P', 'NÃO' => 'T'
						], [
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
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Compra (R$)', [
								'class' => 'form-control money input-sm',
								'value' => moneyFormat($produto->compra),
								'placeholder' => 'EX: 10,50',
								'name' => 'compra',
								'maxlength' => 10
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Markup (%)', [
								'class' => 'form-control input-sm percent',
								'placeholder' => 'EX: 40.00',
								'value' => $produto->markup,
								'name' => 'markup',
								'maxlength' => 7
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Sugerido (R$)', [
								'class' => 'form-control money input-sm',
								'disabled' => true,
								'value' => '0,00'
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Varejo (R$)', [
								'class' => 'form-control money input-sm',
								'value' => moneyFormat($produto->venda),
								'placeholder' => 'EX: 15,55',
								'maxlength' => 10,
								'name' => 'venda'
							]) 
						?>
					</div>	
				</fieldset>
				<fieldset class='col-sm-12'>
					<legend>Atacarejo</legend>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->select('Tipo Multiplicador', [
								'MULTIPLO' => 'M', 'A PARTIR' => 'A'
							], [
								'selected' => $produto->tipo_venda_volume,
								'name' => 'tipo_venda_volume'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Quantidade Atacarejo', [
								'value' => $produto->qtd_vol,
								'placeholder' => 'EX: 5',
								'name' => 'qtd_vol',
								'type' => 'number',
								'maxlength' => 6
							]) 
						?>
					</div>	
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Preço Atacarejo (R$)', [
								'value' => moneyFormat($produto->preco_vol),
								'class' => 'form-control money input-sm',
								'placeholder' => 'EX: 12,99',
								'name' => 'preco_vol',
								'maxlength' => 10
							]) 
						?>
					</div>	
				</fieldset>
				<fieldset class='col-sm-12'>
					<legend>Promoção</legend>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Início da Promoção', [
								'placeholder' => 'EX: ' . date('d/m/Y H:i:s'),
								'value' => date('d/m/Y H:i:s', strtotime(
									$produto->data_inicio_prom
								)),
								'class' => 'form-control input-sm date',
								'name' => 'data_inicio_prom',
								'maxlength' => 10
							]) 
						?>
					</div>	
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Fim da Promoção', [
								'placeholder' => 'EX: ' . date('d/m/Y H:i:s'),
								'value' => date('d/m/Y H:i:s', strtotime(
									$produto->data_final_prom
								)),
								'class' => 'form-control input-sm date',
								'name' => 'data_final_prom',
								'maxlength' => 10
							]) 
						?>
					</div>	
					<div class='col-sm-12'>
						<div class='row'>
							<div class='form-group col-md-3 col-sm-4'>
								<?= $this->Form->input('Preço Promoção (R$)', [
										'value' => moneyFormat($produto->preco_prom),
										'class' => 'form-control money input-sm',
										'placeholder' => 'EX: 12,99',
										'name' => 'preco_prom',
										'maxlength' => 10
									]) 
								?>
							</div>	
							<div class='form-group col-md-7 col-sm-8'>
								<?= $this->Form->input('Descrição Promoção', [
										'value' => $produto->descricao_promocao,
										'placeholder' => 'EX: COMPRE 3 PAGUE 2',
										'name' => 'descricao_promocao',
										'maxlength' => 10
									]) 
								?>
							</div>	
						</div>
					</div>
				</fieldset>
			</fieldset>
			<fieldset class='col-sm-12'>
				<legend>PIS/Cofins</legend>
				<div class='col-sm-12'>
					<div class='row'>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Código NCM', [
									'placeholder' => 'EX: 01051200',
									'value' => $produto->cod_ncm,
									'name' => 'cod_ncm',
									'maxlength' => 9
								]) 
							?>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição NCM', [
									'placeholder' => 'EX: DESCRIÇÃO',
									'value' => 'DESCRIÇÃO',
									'disabled' => true
								]) 
							?>
						</div>	
					</div>
				</div>
				<div class='col-sm-12'>
					<div class='row'>
						<?= $this->Form->input('', [
								'value' => $produto->cstpc,
								'class' => 'hidden',
								'maxlength' => 1,
								'name' => 'cstpc'
							]) 
						?>
						<?= $this->Form->input('', [
								'value' => $produto->cstpc_entrada,
								'name' => 'cstpc_entrada',
								'class' => 'hidden',
								'maxlength' => 1
							]) 
						?>	
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Código CST', [
									'value' => $produto->cstpc,
									'placeholder' => 'EX: 1',
									'maxlength' => 1,
									'name' => 'cstpc'
								]) 
							?>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CST', [
									'placeholder' => 'EX: DESCRIÇÃO',
									'value' => 'DESCRIÇÃO',
									'disabled' => true
								]) 
							?>
						</div>	
					</div>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('Aliquota PIS', [
							'value' => $produto->ali_pis_debito,
							'placeholder' => 'EX: 6.0',
							'name' => 'ali_pis_debito',
							'maxlength' => 7
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('Aliquota Cofins', [
							'value' => $produto->ali_cofins_debito,
							'name' => 'ali_cofins_debito',
							'placeholder' => 'EX: 12.0',
							'maxlength' => 7
						]) 
					?>
				</div>
			</fieldset>
			<fieldset class='col-sm-12'>
				<legend>ICMS</legend>
				<!-- 
					st
					cfop_in
					cest
					icms_in
					icms_out 
				-->
			</fieldset>
			<div class='row'>
				<div class='col-md-8 col-sm-12 col-xs-12 pull-right'>
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
				<a href='/Produto/index' class='btn btn-primary btn-block'>
					<i class='fas fa-angle-double-left'></i> Retornar 
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>
