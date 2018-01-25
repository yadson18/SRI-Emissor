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
								'value' => $produto->compra,
								'placeholder' => 'EX: 10,50',
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
								'name' => 'qtd_vol',
								'type' => 'number',
								'min' => '0',
								'max' => '999999998'
							]) 
						?>
					</div>	
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Preço Atacarejo (R$)', [
								'value' => $produto->preco_vol,
								'class' => 'form-control input-sm money thousands',
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
										'value' => $produto->preco_prom,
										'class' => 'form-control input-sm money millions',
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
						<?= $this->Form->input('', [
								'value' => ($ncm) ? $ncm->ncm : '',
								'class' => 'hidden',
								'name' => 'cod_ncm',
								'maxlength' => 10
							]) 
						?>
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código NCM</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'value' => ($ncm) ? $ncm->ncm : '',
										'placeholder' => 'EX: 01051200',
										'id' => 'codigo-ncm',
										'maxlength' => 10,
										'name' => false
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
						<?= $this->Form->input('', [
								'value' => ($cstpc) ? $cstpc->codigo : '',
								'class' => 'hidden',
								'name' => 'cstpc',
								'maxlength' => 1
							]) 
						?>
						<?= $this->Form->input('', [
								'value' => ($cstpc) ? $cstpc->referencia : '',
								'name' => 'cstpc_entrada',
								'class' => 'hidden',
								'maxlength' => 1
							]) 
						?>	
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CST</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'value' => ($cstpc) ? $cstpc->codigo : '',
										'placeholder' => 'EX: 1',
										'id' => 'codigo-cst',
										'maxlength' => 1,
										'name' => false
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
						<?= $this->Form->input('', [
								'value' => ($st) ? $st->cod_st : '',
								'class' => 'hidden',
								'maxlength' => 4,
								'name' => 'st'
							]) 
						?>	
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CST</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'value' => ($st) ? $st->cod_st : '',
										'placeholder' => 'EX: 0000',
										'id' => 'cod-cst-st',
										'maxlength' => 4,
										'name' => false
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
						<?= $this->Form->input('', [
								'value' => ($cfop) ? $cfop->cfop : '',
								'class' => 'hidden',
								'maxlength' => 4,
								'name' => 'cfop_in'
							]) 
						?>	
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CFOP</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'value' => ($cfop) ? $cfop->cfop : '',
										'placeholder' => 'EX: 0000',
										'id' => 'codigo-cfop',
										'maxlength' => 4,
										'name' => false
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
						<?= $this->Form->input('', [
								'value' => ($cest) ? $cest->cest : '',
								'class' => 'hidden',
								'maxlength' => 7,
								'name' => 'cest'
							]) 
						?>	
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CEST</label>
							<div class='input-group'>
						      	<?= $this->Form->input('', [
										'value' => ($cest) ? $cest->cest : '',
										'placeholder' => 'EX: 2000400',
										'id' => 'codigo-cest',
										'maxlength' => 7,
										'name' => false
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