<div id='grupo-prod-index'>
	<h2 class='page-header'>
		Grupos
		<a href='#' class='btn btn-success'>
			Adicionar Novo <i class='fas fa-plus-circle'></i>
		</a>
	</h2>
	<div class='container-fluid groups-list'>
		<div class='message-box'></div>
		<div class='groups-div'>
			<?php if(!empty($grupos)): ?>
				<?php foreach ($grupos as $grupo): ?>
					<div id=<?= $grupo['cod_grupo'] ?> class='col-md-3 col-sm-4 text-center card'>
						<div class='group-content' style="background-color: #<?= $grupo['cor'] ?>">
							<div class='group-content-actions'>
								<a href=/GrupoProd/edit/<?= $grupo['cod_grupo'] ?> class='btn btn-primary btn-xs'>
									<i class='fas fa-pencil-alt'></i>
								</a>
								<button class='btn btn-danger btn-xs delete' value=<?= $grupo['cod_grupo'] ?> data-toggle='modal' data-target='#delete'>
									<i class='fas fa-trash-alt'></i>
								</button>
							</div>
							<p class='group-content-body'>
								<strong><?= $grupo['descricao'] ?></strong>
							</p>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class='text-center data-not-found'>
					<h4>Você não possui grupos cadastrados. <i class='far fa-frown'></i></h4>
				</div>		    	
			<?php endif; ?>
		</div>
		<div class='row'>
			<div class='col-sm-12 paginator'>
				<?= $this->Paginator->display(); ?>
			</div>
		</div>
	</div>
	<!-- Modal Confirmar Exclusão -->
        <div class='modal fade' id='delete' role='dialog'>
            <div class='modal-dialog' role='document'>
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
</div>