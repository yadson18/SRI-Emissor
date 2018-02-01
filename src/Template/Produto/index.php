<div class='col-sm-12' id='product'>
	<h2 class='page-header'>
		Produtos 
		<a href='/Produto/add' class='btn btn-success'>
			Adicionar Novo <i class="fas fa-plus-circle"></i>
		</a>
	</h2>
	<div id='message-box'></div>
	<div class='table-responsive fixed-height'>
		<table class='table table-bordered'>
		    <thead>
		      	<tr>
		      		<th>#</th>
		        	<th>Código Interno</th>
		        	<th>Descrição</th>
		        	<th>Código de Barras</th>
		        	<th>ICMS Dentro</th>
		        	<th>ICMS Fora</th>
		        	<th>CST ICMS</th>
		        	<th>NCM</th>
		        	<th>CEST</th>
		        	<th>Unidade de Medida</th>
		        	<th>Preço (R$)</th>
		        	<th>Ações</th>
		      	</tr>
		    </thead>
		    <?php if(!empty($produtos)): ?>
			    <tbody class='text-capitalize'>
			    		<?php foreach($produtos as $index => $produto): ?>
				    		<tr>
				    			<th><?= ($index + 1) ?></th>
					        	<td><?= $produto['cod_interno'] ?></td>
								<td><?= mb_strtolower($produto['descricao']) ?></td>
								<td><?= $produto['cod_produto'] ?></td>
								<td><?= $produto['icms_in'] ?></td>
								<td><?= $produto['icms_out'] ?></td>
								<td><?= $produto['st'] ?></td>
								<td><?= $produto['cod_ncm'] ?></td>
								<td><?= $produto['cest'] ?></td>
								<td><?= mb_strtolower($produto['unidade']) ?></td>
								<td class='money millions'><?= unmask($produto['venda']) ?></td>
								<td class='actions'>
									<a class='btn btn-primary action-btn' href=/Produto/edit/<?= $produto['cod_interno'] ?>>
										<i class='fas fa-pencil-alt'></i>
									</a>
									<button class='btn btn-danger action-btn delete' data-toggle='modal' data-target='#delete' value=<?= $produto['cod_interno'] ?>>
										<i class='fas fa-trash-alt'></i>
									</button>
								</td>
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
	<div class='col-sm-12'>
		<?= $this->Paginator->display(); ?>
	</div>
	<!-- Modal Confirmar Exclusão -->
        <div class='modal fade' id='delete' role='dialog'>
            <div class='col-sm-4 col-sm-offset-4 modal-top'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>
                            <i class='fas fa-times'></i>
                        </button>
                        <h4 class='modal-title text-center'>Excluir Destinatário</h4>
                    </div>
                    <div class='modal-body text-center'>
                        <h4>Deseja realmente excluir este destinatário?</h4>
                    </div>
                    <div class='modal-footer'>
                    	<button data-dismiss='modal' class='btn btn-danger exit'>
                    		Não <i class='fas fa-times'></i>
                    	</button>
                    	<button class='btn btn-success confirm' data-dismiss='modal'>
                    		Sim <i class='fas fa-check'></i>
                    	</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal End -->
</div>