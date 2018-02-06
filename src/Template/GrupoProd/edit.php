<div id='grupo-prod-edit'>
	<?php if(!empty($grupo)): ?>
		<?= $this->Form->start('', ['class' => 'form-content col-sm-12']) ?>
			<div class='form-header text-center'>
				<h4>Modificar Grupo</h4>
			</div>
			<div class='form-body'>
				<div class='message-box'>
					<?= $this->Flash->showMessage() ?>
				</div>
				<div class='form-data'>
					<div class='row'>
						<div class='form-group col-md-1 col-sm-2'>
							<?= $this->Form->input('Cor', [
									'value' => '#' . $grupo->cor,
									'type' => 'color'
								]) 
							?>
						</div>
						<div class='form-group col-sm-5'>
							<label>Descrição</label>
							<div class='input-group'>
								<?= $this->Form->input('', [
										'placeholder' => 'EX: CARNES',
										'value' => $grupo->descricao,
										'name' => 'descricao',
										'autofocus' => true,
										'maxlength' => 20
									]) 
								?>					
								<span class='input-group-btn'>
								    <button class='btn btn-success btn-block btn-sm'>
										Salvar <i class='fas fa-save'></i>
									</button>						    
								</span>
							</div>
						</div>
					</div>	
				</div>
				<div class='form-subcontent'>
					<div class='form-group' id='breadcrumb'>
						<ul class='nav nav-tabs destinatarie-type'>
							<li role='breadcrumb-item' class='active'>
								<a href='#' id='PRODUTOS'>Produtos do Grupo</a>
							</li>
							<li role='breadcrumb-item'>
								<a href='#' id='SUBGRUPOS'>Subgrupos</a>
							</li>
						</ul>
					</div>
					<div class='produtos'>
						<div class='table-responsive fixed-height'>
							<table class='table table-bordered'>
							    <thead>
							      	<tr>
							      		<th>#</th>
							        	<th>Código Interno</th>
							        	<th>Descrição</th>
							        	<th>Código de Barras</th>
							        	<th>Unidade de Medida</th>
							        	<th>Preço (R$)</th>
							        	<?php if ($codGrupo !== 0): ?>
							        		<th>Ações</th>
							        	<?php endif ?>
							      	</tr>
							    </thead>
							    <?php if(!empty($produtos)): ?>
								    <tbody class='text-capitalize'>
								    		<?php foreach($produtos as $index => $produto): ?>
									    		<tr id=<?= $produto['cod_interno'] ?>>
										    		<th><?= ($index + 1) ?></th>
											        <td><?= $produto['cod_interno'] ?></td>
													<td><?= mb_strtolower($produto['descricao']) ?></td>
													<td><?= $produto['cod_produto'] ?></td>
													<td><?= mb_strtolower($produto['unidade']) ?></td>
													<td class='money millions'><?= unmask($produto['venda']) ?></td>
													<?php if ($codGrupo !== 0): ?>
														<td class='actions'>
															<button value=<?= $produto['cod_interno'] ?> class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delete' type='button'>
																<i class='fas fa-trash-alt'></i>
															</button>
														</td>
													<?php endif ?>
										      	</tr>
									      	<?php endforeach; ?>
								    </tbody>
								<?php endif; ?>
							</table>
							<?php if(empty($produtos)): ?>
								<div class='text-center data-not-found'>
									<h4>Nada a ser exibido. <i class='far fa-frown'></i></h4>
								</div>		    	
							<?php endif; ?>
						</div>
					</div>
					<div class='subgrupos hidden'>
						<div class='groups-div'>
							<?php if(!empty($subgrupos)): ?>
								<?php foreach ($subgrupos as $subgrupo): ?>
									<div id=<?= $subgrupo['cod_subgrupo'] ?> class='col-md-3 col-sm-4 text-center card'>
										<div class='group-content'>
											<div class='group-content-actions'>
												<a href=/SubgrupoProd/edit/<?= $subgrupo['cod_subgrupo'] ?> class='btn btn-primary btn-xs'>
													<i class='fas fa-pencil-alt'></i>
												</a>
												<button class='btn btn-danger btn-xs delete' type='button' value=<?= $subgrupo['cod_subgrupo'] ?> data-toggle='modal' data-target='#delete'>
													<i class='fas fa-trash-alt'></i>
												</button>
											</div>
											<p class='group-content-body'>
												<strong><?= $subgrupo['descricao'] ?></strong>
											</p>
										</div>
									</div>
								<?php endforeach; ?>
							<?php else: ?>
								<div class='text-center data-not-found'>
									<h4>
										Este grupo não possui subgrupos cadastrados. <i class='far fa-frown'></i>
									</h4>
								</div>		    	
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class='form-footer row'>
				<div class='col-sm-12'>
					<div class='row'>
						<div class='col-sm-3'>
							<div class='return'>
								<a href='/GrupoProd/index' class='btn btn-primary btn-block'>
									<i class='fas fa-angle-double-left'></i> Retornar
								</a>
							</div>
						</div>
						<div class='col-sm-9 produtos'>
							<?= $this->Paginator->display(); ?>
						</div>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
	<?php else: ?>
		<div class='col-sm-12 text-center data-not-found'>
			<h4>Desculpe, grupo inexistente, deseja retornar?.</h4>
			<div class='form-group col-sm-4 col-sm-offset-4'>
				<a href='/GrupoProd/index' class='btn btn-primary btn-block'>
					<i class='fas fa-angle-double-left'></i> Retornar 
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>
