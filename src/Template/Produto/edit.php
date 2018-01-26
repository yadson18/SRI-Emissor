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
					<?= $this->Form->select('Grupo', array_column(
							$grupos, 'cod_grupo', 'descricao'
						), [
							'selected' => $produto->cod_grupo,
							'name' => 'cod_grupo'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Subgrupo', array_column(
							$subgrupos, 'cod_subgrupo', 'descricao'
						), [
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
							'placeholder' => 'EX: 58652485620574',
							'value' => $produto->cod_produto,
							'name' => 'cod_produto',
							'autofocus' => true,
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
								'class' => 'form-control input-sm money millions',
								'placeholder' => 'EX: 10,50',
								'value' => $produto->compra,
								'name' => 'compra'
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
								'class' => 'form-control input-sm preco-sugerido money millions',
								'value' => precoSugerido($produto->compra, $produto->markup),
								'required' => false,
								'disabled' => true,
								'name' => false
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Varejo (R$)', [
								'class' => 'form-control input-sm money millions',
								'value' => $produto->venda,
								'placeholder' => 'EX: 15,55',
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
								'max' => '999999998',
								'name' => 'qtd_vol',
								'type' => 'number',
								'min' => '0'
							]) 
						?>
					</div>	
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Preço Atacarejo (R$)', [
								'class' => 'form-control input-sm money thousands',
								'value' => $produto->preco_vol,
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
								'class' => 'form-control input-sm date-time',
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
								'class' => 'form-control input-sm date-time',
								'name' => 'data_final_prom',
								'maxlength' => 10
							]) 
						?>
					</div>	
					<div class='col-sm-12'>
						<div class='row'>
							<div class='form-group col-md-3 col-sm-4'>
								<?= $this->Form->input('Preço Promoção (R$)', [
										'class' => 'form-control input-sm money millions',
										'value' => $produto->preco_prom,
										'placeholder' => 'EX: 12,99',
										'name' => 'preco_prom'
									]) 
								?>
							</div>	
							<div class='form-group col-md-7 col-sm-8'>
								<?= $this->Form->input('Descrição Promoção', [
										'value' => $produto->descricao_promocao,
										'placeholder' => 'EX: COMPRE 3 PAGUE 2',
										'name' => 'descricao_promocao',
										'maxlength' => 25
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
							<label>Código NCM</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'placeholder' => 'EX: 01051200',
										'value' => $produto->cod_ncm,
										'name' => 'cod_ncm',
										'maxlength' => 8
									]) 
								?>
						      	<span class='input-group-btn'>
						        	<button class='btn btn-primary btn-sm' type='button'>
						        		Consultar <i class='fas fa-search'></i>
						        	</button>
						      	</span>
						    </div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição NCM', [
									'value' => ($ncm) ? $ncm->descricao : '',
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
				</div>
				<div class='col-sm-12'>
					<div class='row'>
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CSTPC</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'value' => $produto->cstpc,
										'placeholder' => 'EX: 1',
										'name' => 'cstpc',
										'maxlength' => 1
									]) 
								?> 
						      	<span class='input-group-btn'>
						        	<button class='btn btn-primary btn-sm' type='button'>
						        		Consultar <i class='fas fa-search'></i>
						        	</button>
						      	</span>
						    </div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CSTPC', [
									'value' => ($cstpc) ? $cstpc->descricao : '',
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('Aliquota PIS', [
							'class' => 'form-control input-sm ali-pis',
							'value' => $produto->ali_pis_debito,
							'placeholder' => 'EX: 6.0',
							'name' => 'ali_pis_debito',
							'maxlength' => 6
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('Aliquota Cofins', [
							'class' => 'form-control input-sm ali-pis',
							'value' => $produto->ali_cofins_debito,
							'name' => 'ali_cofins_debito',
							'placeholder' => 'EX: 12.0',
							'maxlength' => 6
						]) 
					?>
				</div>
			</fieldset>
			<fieldset class='col-sm-12'>
				<legend>ICMS</legend>
				<div class='col-sm-12'>
					<div class='row'>
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CST</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'placeholder' => 'EX: 0000',
										'value' => $produto->st,
										'maxlength' => 4,
										'name' => 'st'
									]) 
								?>
						      	<span class='input-group-btn'>
						        	<button class='btn btn-primary btn-sm' type='button'>
						        		Consultar <i class='fas fa-search'></i>
						        	</button>
						      	</span>
						    </div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CST', [
									'value' => ($st) ? $st->descricao : '',
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
				</div>
				<div class='col-sm-12'>
					<div class='row'>
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CFOP</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'value' => $produto->cfop_in,
										'placeholder' => 'EX: 0000',
										'name' => 'cfop_in',
										'maxlength' => 4
									]) 
								?>
						      	<span class='input-group-btn'>
						        	<button class='btn btn-primary btn-sm' type='button'>
						        		Consultar <i class='fas fa-search'></i>
						        	</button>
						      	</span>
						    </div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CFOP', [
									'value' => ($cfop) ? $cfop->descricao : '',
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
				</div>
				<div class='col-sm-12'>
					<div class='row' id='cest-block'>
						<?= $this->Form->input('', [
								'value' => $codRegTrib,
								'id' => 'cod_reg_trib',
								'required' => false,
								'class' => 'hidden',
								'maxlength' => 1,
								'name' => false
							]) 
						?>
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CEST</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'placeholder' => 'EX: 2000400',
										'value' => $produto->cest,
										'maxlength' => 7,
										'name' => 'cest'
									]) 
								?>
						      	<span class='input-group-btn'>
						        	<button class='btn btn-primary btn-sm' type='button'>
						        		Consultar <i class='fas fa-search'></i>
						        	</button>
						      	</span>
						    </div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CEST', [
									'value' => ($cest) ? $cest->descricao : '',
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('ICMS Dentro', [
							'class' => 'form-control input-sm icms',
							'value' => $produto->icms_in,
							'placeholder' => 'EX: 17.00',
							'name' => 'icms_in',
							'maxlength' => 4
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('ICMS Fora', [
							'class' => 'form-control input-sm icms',
							'value' => $produto->icms_out,
							'name' => 'icms_out',
							'placeholder' => 'EX: 12.00',
							'maxlength' => 4
						]) 
					?>
				</div>
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