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
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Compra (R$)', [
								'placeholder' => 'EX: 10,50',
								'class' => 'form-control money input-sm',
								'value' => moneyFormat($produto->compra),
								'maxlength' => 10,
								'required' => true,
								'name' => 'compra'
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Markup (%)', [
								'placeholder' => 'EX: 40.00',
								'class' => 'form-control input-sm percent',
								'value' => $produto->markup,
								'maxlength' => 7,
								'required' => true,
								'name' => 'markup'
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Sugerido (R$)', [
								'class' => 'form-control money input-sm',
								'value' => '0,00',
								'disabled' => true
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Varejo (R$)', [
								'placeholder' => 'EX: 15,55',
								'class' => 'form-control money input-sm',
								'value' => moneyFormat($produto->venda),
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
						<?= $this->Form->input('Preço Atacarejo (R$)', [
								'placeholder' => 'EX: 12,99',
								'class' => 'form-control money input-sm',
								'value' => moneyFormat($produto->preco_vol),
								'maxlength' => 10,
								'required' => true,
								'name' => 'preco_vol'
							]) 
						?>
					</div>	
				</fieldset>
				<fieldset class='col-sm-12'>
					<legend>Promoção</legend>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Início da Promoção', [
								'placeholder' => 'EX: ' . date('d/m/Y H:i:s'),
								'class' => 'form-control input-sm date',
								'value' => date(
									'd/m/Y H:i:s', strtotime($produto->data_inicio_prom)
								),
								'maxlength' => 10,
								'required' => true,
								'name' => 'data_inicio_prom'
							]) 
						?>
					</div>	
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Fim da Promoção', [
								'placeholder' => 'EX: ' . date('d/m/Y H:i:s'),
								'class' => 'form-control input-sm date',
								'value' => date(
									'd/m/Y H:i:s', strtotime($produto->data_final_prom)
								),
								'maxlength' => 10,
								'required' => true,
								'name' => 'data_final_prom'
							]) 
						?>
					</div>	
					<div class='col-sm-12'>
						<div class='row'>
							<div class='form-group col-md-3 col-sm-4'>
								<?= $this->Form->input('Preço Promoção (R$)', [
										'placeholder' => 'EX: 12,99',
										'class' => 'form-control money input-sm',
										'value' => moneyFormat($produto->preco_prom),
										'maxlength' => 10,
										'required' => true,
										'name' => 'preco_prom'
									]) 
								?>
							</div>	
							<div class='form-group col-md-7 col-sm-8'>
								<?= $this->Form->input('Descrição Promoção', [
										'placeholder' => 'EX: COMPRE 3 PAGUE 2',
										'class' => 'form-control input-sm',
										'value' => $produto->descricao_promocao,
										'maxlength' => 10,
										'required' => true,
										'name' => 'descricao_promocao'
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
									'class' => 'form-control input-sm',
									'value' => $produto->cod_ncm,
									'maxlength' => 9,
									'required' => true,
									'name' => 'cod_ncm'
								]) 
							?>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição NCM', [
									'placeholder' => 'EX: DESCRIÇÃO',
									'class' => 'form-control input-sm',
									'value' => 'DESCRIÇÃO',
									'disabled' => true,
									'maxlength' => 9
								]) 
							?>
						</div>	
					</div>
				</div>
				<div class='col-sm-12'>
					<div class='row'>
						<?= $this->Form->input('', [
								'class' => 'hidden',
								'value' => $produto->cstpc,
								'maxlength' => 1,
								'required' => true,
								'name' => 'cstpc'
							]) 
						?>
						<?= $this->Form->input('', [
								'class' => 'hidden',
								'value' => $produto->cstpc_entrada,
								'maxlength' => 1,
								'required' => true,
								'name' => 'cstpc_entrada'
							]) 
						?>	
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Código CST', [
									'placeholder' => 'EX: 1',
									'class' => 'form-control input-sm',
									'value' => $produto->cstpc,
									'maxlength' => 1,
									'required' => true,
									'name' => 'cstpc'
								]) 
							?>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CST', [
									'placeholder' => 'EX: DESCRIÇÃO',
									'class' => 'form-control input-sm',
									'value' => 'DESCRIÇÃO',
									'disabled' => true,
									'maxlength' => 9
								]) 
							?>
						</div>	
					</div>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('Aliquota PIS', [
							'placeholder' => 'EX: 6.0',
							'class' => 'form-control input-sm',
							'value' => $produto->ali_pis_debito,
							'name' => 'ali_pis_debito',
							'maxlength' => 7
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('Aliquota Cofins', [
							'placeholder' => 'EX: 12.0',
							'class' => 'form-control input-sm',
							'value' => $produto->ali_cofins_debito,
							'name' => 'ali_cofins_debito',
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
				<a href='/Cadastro/index' class='btn btn-primary btn-block'>
					<i class='fas fa-angle-double-left'></i> Retornar 
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>
