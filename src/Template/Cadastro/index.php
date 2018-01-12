<div class='col-sm-12'>
	<h2 class='page-header'>
		Destinatários 
		<button class='btn btn-success'>
			Adicionar Novo <i class="fas fa-plus-circle"></i>
		</button>
	</h2>
	<div class='table-responsive fixed-height'>
		<table class='table table-bordered'>
		    <thead>
		      	<tr>
		      		<th>#</th>
		        	<th>Código</th>
		        	<th>CNPJ/CPF</th>
		        	<th>Razão</th>
		        	<th>Fantasia</th>
		        	<th>Estado</th>
		        	<th>CEP</th>
		        	<th>Cidade</th>
		        	<th>Endereço</th>
		        	<th>Bairro</th>
		        	<th>Ações</th>
		      	</tr>
		    </thead>
		    <?php if($cadastros): ?>
			    <tbody class='text-capitalize'>
			    		<?php foreach($cadastros as $index => $cadastro): ?>
				    		<tr>
				    			<th><?= ($index + 1) ?></th>
					        	<td><?= $cadastro['cod_cadastro'] ?></td>
								<td class='cnpjCpfMask'><?= unmask($cadastro['cnpj']) ?></td>
								<td><?= mb_strtolower($cadastro['razao']) ?></td>
								<td><?= mb_strtolower($cadastro['fantasia']) ?></td>
								<td><?= $cadastro['estado'] ?></td>
								<td class='cepMask'><?= unmask($cadastro['cep']) ?></td>
								<td><?= mb_strtolower($cadastro['cidade']) ?></td>
								<td><?= mb_strtolower($cadastro['endereco']) ?></td>
								<td><?= mb_strtolower($cadastro['bairro']) ?></td>
								<td class='actions'>
									<a class='btn btn-primary action-btn' href=/Cadastro/edit/<?= $cadastro['cod_cadastro'] ?>>
										<i class='fas fa-pencil-alt'></i>
									</a>
									<button class='btn btn-danger action-btn' data-toggle='modal' data-target='#delete'>
										<i class='fas fa-trash-alt'></i>
									</button>
								</td>
				      		</tr>
				      	<?php endforeach; ?>
			    </tbody>
			<?php else: ?>
		</table>
			<div class='text-center data-not-found'>
				<h4>Nada a ser exibido. <i class='far fa-frown'></i></h4>
			</div>		    	
		<?php endif; ?>
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
                    	<button class='btn btn-success'>
                    		Sim <i class='fas fa-check'></i>
                    	</button>
                    	<button data-dismiss='modal' class='btn btn-danger'>
                    		Não <i class='fas fa-times'></i>
                    	</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal End -->
</div>