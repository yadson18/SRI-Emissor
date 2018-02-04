<div class='col-sm-12' id='groups'>
	<h2 class='page-header'>
		Grupos
		<a href='#' class='btn btn-success'>
			Adicionar Novo <i class="fas fa-plus-circle"></i>
		</a>
	</h2>
	<div id='message-box'></div>
	<div class='groups-div'>
		<?php foreach ($grupos as $grupo): ?>
			<div id=<?= $grupo['cod_grupo'] ?> class='col-sm-3 text-center card'>
				<div class='group-content'>
					<div class='group-content-actions'>
						<button class='btn btn-primary btn-xs' data-toggle='modal' data-target='#edit'>
							<i class='fas fa-pencil-alt'></i>
						</button>
						<button class='btn btn-danger btn-xs delete' value=<?= $grupo['cod_grupo'] ?> data-toggle='modal' data-target='#delete'>
							<i class='fas fa-trash-alt'></i>
						</button>
					</div>
					<p class='group-content-body'><?= $grupo['descricao'] ?></p>
				</div>
			</div>
		<?php endforeach; ?>
		<?php if(empty($grupos)): ?>
			<div class='text-center data-not-found'>
				<h4>Você não possui grupos cadastrados. <i class='far fa-frown'></i></h4>
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
                        <h4 class='modal-title text-center'>Excluir Grupo</h4>
                    </div>
                    <div class='modal-body text-center'>
                        <h4>Deseja realmente excluir este grupo?</h4>
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
    <!-- Modal Editar -->
        <div class='modal fade' id='edit' role='dialog'>
            <div class='modal-dialog modal-md' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>
                            <i class='fas fa-times'></i>
                        </button>
                        <h4 class='modal-title text-center'>Modificar Grupo</h4>
                    </div>
                    <div class='modal-body'>
                    	<div class='row'>
	                        <?= $this->Form->start('', ['class' => 'col-sm-12']) ?>
	                        	<?= $this->Form->input('', [
		                        		'type' => 'number',
		                        		'name' => 'cod_grupo',
		                        		'class' => 'hidden'
		                        	]) 
		                        ?>
	                        	<div class='form-group col-sm-3'>
		                        	<?= $this->Form->input('Cor', [
		                        			'type' => 'color'
		                        		]) 
		                        	?>
	                        	</div>
	                        	<div class='form-group col-sm-9'>
		                        	<?= $this->Form->input('Descrição', [
		                        			'placeholder' => 'EX: CARNES'
		                        		]) 
		                        	?>
	                        	</div>
	                        <?= $this->Form->end() ?>
                    	</div>
                    </div>
                    <div class='modal-footer'>
                    	<button data-dismiss='modal' class='btn btn-danger exit'>
                    		Cancelar <i class='fas fa-times'></i>
                    	</button>
                    	<button class='btn btn-success save' data-dismiss='modal'>
                    		Salvar <i class='fas fa-save'></i>
                    	</button>
                    </div>
                    <div class='text-center loading hidden'>
						<div class='loading-content edit-loading-height'>
							<i class='fas fa-circle-notch fa-spin fa-3x'></i>
	                    	<h5>Carregando os dados...</h5>
						</div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal End -->
</div>
<script type="text/javascript">
	$.ajax({
		url: '/GrupoProd/getGrupoPorCod',
		method: 'POST',
		dataType: 'json',
		data: { cod_grupo: '3' }
	})
	.always(function(data, status) {
		console.log(data);
	});
</script>