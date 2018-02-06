<div id='produto-add'>
	<?= $this->Form->start('', ['class' => 'form-content col-sm-12']) ?>
		<div class='form-header text-center'>
			<h4>Adicionar Produto</h4>
		</div>
		<div class='form-body'>
			<div class='message-box'>
				<?= $this->Flash->showMessage() ?>
			</div>
			<fieldset>
				<legend>
					<i class='fas fa-angle-double-right text-primary'></i> Classificação Mercadológica
				</legend>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Grupo', array_column(
							$grupos, 'cod_grupo', 'descricao'
						), [
							'name' => 'cod_grupo'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Subgrupo', array_column(
							$subgrupos, 'cod_subgrupo', 'descricao'
						), [
							'name' => 'cod_subgrupo'
						]) 
					?>
				</div>
			</fieldset>
			<fieldset>
				<legend>
					<i class='fas fa-angle-double-right text-primary'></i> Dados Cadastrais
				</legend>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->input('Código de barras', [
							'placeholder' => 'EX: 58652485620574',
							'name' => 'cod_produto',
							'autofocus' => true,
							'maxlength' => 14
						]) 
					?>
				</div>
				<div class='form-group col-md-6 col-sm-8'>
					<?= $this->Form->input('Descrição', [
							'placeholder' => 'EX: CREME DENTAL 75G',
							'maxlength' => 40
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Unidade de Medida', array_column(
							$unidades, 'cod', 'descricao'
						), [
							'name' => 'unidade'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Balança', [
							'SIM' => 'S', 'NÃO' => 'N'
						]) 
					?>
				</div>
				<div class='form-group col-md-3 col-sm-4'>
					<?= $this->Form->select('Fabricação Própria', [
							'SIM' => 'P', 'NÃO' => 'T'
						], [
							'name' => 'fabricacao'
						]) 
					?>
				</div>
			</fieldset>
			<fieldset>
				<legend>
					<i class='fas fa-angle-double-right text-primary'></i> Preço
				</legend>
				<fieldset class='col-sm-12'>
					<legend>
						<i class='fas fa-angle-right text-primary'></i> Varejo
					</legend>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Compra (R$)', [
								'class' => 'form-control input-sm money millions',
								'placeholder' => 'EX: 10,50',
								'name' => 'compra',
								'value' => '0,00'
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Markup (%)', [
								'class' => 'form-control input-sm percent',
								'placeholder' => 'EX: 40.00',
								'name' => 'markup',
								'value' => '0.00',
								'maxlength' => 7
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Sugerido (R$)', [
								'class' => 'form-control input-sm preco-sugerido money millions',
								'required' => false,
								'disabled' => true,
								'value' => '0,00',
								'name' => false
							]) 
						?>
					</div>
					<div class='form-group col-md-3	col-sm-3'>
						<?= $this->Form->input('Preço Varejo (R$)', [
								'class' => 'form-control input-sm money millions',
								'placeholder' => 'EX: 15,55',
								'name' => 'venda',
								'value' => '0,00'
							]) 
						?>
					</div>	
				</fieldset>
				<fieldset class='col-sm-12'>
					<legend>
						<i class='fas fa-angle-right text-primary'></i> Atacarejo
					</legend>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->select('Tipo Multiplicador', [
								'MULTIPLO' => 'M', 'A PARTIR' => 'A'
							], [
								'name' => 'tipo_venda_volume'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Quantidade Atacarejo', [
									'placeholder' => 'EX: 5',
									'max' => '999999998',
									'name' => 'qtd_vol',
									'type' => 'number',
									'value' => '0',
									'min' => '0'
								]) 
							?>
					</div>	
					<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Preço Atacarejo (R$)', [
									'class' => 'form-control input-sm money thousands',
									'placeholder' => 'EX: 12,99',
									'name' => 'preco_vol',
									'maxlength' => 10,
									'value' => '0,00'
								]) 
							?>
					</div>	
				</fieldset>
				<fieldset class='col-sm-12'>
					<legend>
						<i class='fas fa-angle-right text-primary'></i> Promoção
					</legend>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Início da Promoção', [
								'placeholder' => 'EX: ' . date('d/m/Y H:i:s'),
								'class' => 'form-control input-sm date-time',
								'name' => 'data_inicio_prom',
								'maxlength' => 10
							]) 
						?>
					</div>	
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Fim da Promoção', [
								'placeholder' => 'EX: ' . date('d/m/Y H:i:s'),
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
										'placeholder' => 'EX: 12,99',
										'name' => 'preco_prom',
										'value' => '0,00'
									]) 
								?>
							</div>	
							<div class='form-group col-md-7 col-sm-8'>
								<?= $this->Form->input('Descrição Promoção', [
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
			<fieldset>
				<legend>
					<i class='fas fa-angle-double-right text-primary'></i> PIS/Cofins
				</legend>
				<div class='row'>
					<div class='consultar col-sm-12'>
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código NCM</label>
							<div class='input-group'>
							    <?= $this->Form->input('', [
							      		'class' => 'form-control input-sm text-uppercase disabled',
										'placeholder' => 'EX: 01051200',
										'name' => 'cod_ncm',
										'maxlength' => 8
									]) 
								?>
							    <span class='input-group-btn'>
							      	<?= $this->Form->button("Alterar <i class='fas fa-search'></i>", [
							      			'class' => 'btn btn-primary btn-sm',
							      			'data-target' => '#finder',
							      			'data-toggle' => 'modal',
							      			'data-find' => 'ncm',
							      			'type' => 'button'
							      		]) 
							      	?>
							    </span>
							</div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição NCM', [
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
					<div class='consultar col-sm-12'>
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CSTPC</label>
							<div class='input-group'>
							    <?= $this->Form->input('', [
							      		'class' => 'form-control input-sm text-uppercase disabled',
										'placeholder' => 'EX: 1',
										'name' => 'cstpc',
										'maxlength' => 1
									]) 
								?> 
							    <span class='input-group-btn'>
							        <?= $this->Form->button("Alterar <i class='fas fa-search'></i>", [
							      			'class' => 'btn btn-primary btn-sm',
							      			'data-target' => '#finder',
							      			'data-toggle' => 'modal',
							      			'data-find' => 'cstpc',
							      			'type' => 'button'
							      		]) 
							      	?>
							    </span>
							</div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CSTPC', [
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
					<div class='col-sm-12'>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Aliquota PIS', [
									'class' => 'form-control input-sm ali-pis',
									'placeholder' => 'EX: 6.0',
									'name' => 'ali_pis_debito',
									'value' => '0.0000',
									'maxlength' => 6
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Aliquota Cofins', [
									'class' => 'form-control input-sm ali-pis',
									'name' => 'ali_cofins_debito',
									'placeholder' => 'EX: 12.0',
									'value' => '0.0000',
									'maxlength' => 6
								]) 
							?>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>
					<i class='fas fa-angle-double-right text-primary'></i> ICMS
				</legend>
				<div class='row'>
					<div class='consultar col-sm-12'>
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CST</label>
							<div class='input-group'>
							    <?= $this->Form->input('', [
							      		'class' => 'form-control input-sm text-uppercase disabled',
										'placeholder' => 'EX: 0000',
										'maxlength' => 4,
										'name' => 'st'
									]) 
								?>
							    <span class='input-group-btn'>
							        <?= $this->Form->button("Alterar <i class='fas fa-search'></i>", [
							      			'class' => 'btn btn-primary btn-sm',
							      			'data-target' => '#finder',
							      			'data-toggle' => 'modal',
							      			'data-find' => 'st',
							      			'type' => 'button'
							      		]) 
							      	?>
							    </span>
							</div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CST', [
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
					<div class='consultar col-sm-12'>
						<div class='form-group col-md-3 col-sm-4'>
							<label>Código CFOP</label>
							<div class='input-group'>
							    <?= $this->Form->input('', [
							      		'class' => 'form-control input-sm text-uppercase disabled',
										'placeholder' => 'EX: 0000',
										'name' => 'cfop_in',
										'maxlength' => 4
									]) 
								?>
							    <span class='input-group-btn'>
							        <?= $this->Form->button("Alterar <i class='fas fa-search'></i>", [
							      			'class' => 'btn btn-primary btn-sm',
							      			'data-target' => '#finder',
							      			'data-toggle' => 'modal',
							      			'data-find' => 'cfop',
							      			'type' => 'button'
							      		]) 
							      	?>
							    </span>
							</div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CFOP', [
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
					<div class='consultar col-sm-12' id='cest-block'>
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
										'class' => 'form-control input-sm text-uppercase disabled',
										'placeholder' => 'EX: 2000400',
										'maxlength' => 7,
										'name' => 'cest'
									]) 
								?>
							    <span class='input-group-btn'>
							        <?= $this->Form->button("Alterar <i class='fas fa-search'></i>", [
							      			'class' => 'btn btn-primary btn-sm',
							      			'data-target' => '#finder',
							      			'data-toggle' => 'modal',
							      			'data-find' => 'cest',
							      			'type' => 'button'
							      		]) 
							      	?>
							    </span>
							</div>
						</div>	
						<div class='form-group col-md-7 col-sm-8'>
							<?= $this->Form->input('Descrição CEST', [
									'required' => false,
									'disabled' => true,
									'name' => false
								]) 
							?>
						</div>	
					</div>
					<div class='col-sm-12'>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('ICMS Dentro', [
									'class' => 'form-control input-sm icms',
									'placeholder' => 'EX: 17.00',
									'name' => 'icms_in',
									'value' => '0.00',
									'maxlength' => 4
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('ICMS Fora', [
									'class' => 'form-control input-sm icms',
									'placeholder' => 'EX: 12.00',
									'name' => 'icms_out',
									'value' => '0.00',
									'maxlength' => 4
								]) 
							?>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<div class='form-footer row'>
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
	<!-- Modal de Consultas -->
		<div class='modal fade' id='finder' tabindex='-1' role='dialog'>
			<div class='modal-dialog modal-lg' role='document'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
						<h4 class='modal-title text-center' id='exampleModalLabel'>Consultar</h4>
					</div>
					<div class='modal-body'>
						<div class='col-sm-12 message-box'></div>
						<div class='row'>
							<div class='col-sm-6 form-group'>
		  						<div class='input-group icon-right'>
		  							<span class='input-group-btn'>
		      							<select class='btn btn-default btn-sm filter'>
				      						<option value='1'>CÓDIGO</option>
				      						<option value='2'>DESCRIÇÃO</option>
		      							</select>
		  							</span>
				      				<?= $this->Form->input('', [
				                           	'placeholder' => 'Digite sua busca aqui',
				                           	'class' => 'form-control input-sm search-content text-uppercase',
				                           	'required' => false,
				                           	'name' => false,
				                           	'id' => false
				                       	]) 
				                    ?>
		                			<i class='fas fa-search icon icon-sm button find'></i>
		  						</div>
							</div>
							<div class='col-sm-12'>
								<div class='table-responsive fixed-height'>
									<table class='table table-bordered'>
										<thead>
											<tr>
												<th>#</th>
												<th>Código</th>
												<th>Descrição</th>
												<th>Selecionado</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-danger' data-dismiss='modal'>
							Fechar <i class='fas fa-times'></i>
						</button>
			 			<button type='button' class='btn btn-success inserir'>
			 				Concluir <i class='fas fa-check'></i>
			 			</button>
					</div>
					<div class='text-center loading hidden'> 
						<div class='loading-content change-loading-height'>
							<i class='fas fa-circle-notch fa-spin fa-3x'></i>
			                <h5>Carregando os dados...</h5>
						</div>
		            </div>
				</div>
			</div>
		</div>
	<!-- Fim do Modal -->
</div>


