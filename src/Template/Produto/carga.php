<div id='produto-carga'>
	<h2 class='page-header'>
		Carga de Produto
		<button class='btn btn-primary enviar-carga' value='Alterados'>
			Carga Parcial <i class='fas fa-plus-circle'></i>
		</button>
		<button class='btn btn-success enviar-carga' value='Geral'>
			Carga Geral <i class='fas fa-plus-circle'></i>
		</button>
	</h2>
	<div class='container-fluid caixa-lista'>
		<div class='message-box'></div>
		<div class='table-responsive fixed-height'>
			<table class='table table-bordered'>
			    <thead>
			      	<tr>
			      		<th>#</th>
			        	<th>Status do Envio</th>
			        	<th>Caixa</th>
			        	<th>Modelo Impressora</th>
			        	<th>Online</th>
			        	<th>Carga do Caixa</th>
			        	<th>Selecionado</th>
			      	</tr>
			    </thead>
			    <?php if (!empty($caixas)): ?>
				    <tbody>
				    	<?php foreach ($caixas as $index => $caixa): ?>
					    	<tr id=<?=$caixa['caixa']?>>
					    		<th><?= ($index + 1) ?></th>
					    		<td class='status-envio alert-info'>
									<i class='fas fa-info'></i>
									<p>Nenhuma carga foi enviada ainda.</p>
								</td>
								<td><?=$caixa['caixa']?></td>
								<td><?=$caixa['modeloimpressora']?></td>
								<?php if($caixa['online'] === 'T'): ?>
									<td><i class='fas fa-check text-success'></i></td>
								<?php else: ?>
									<td><i class='fas fa-times fa-lg text-danger'></i></td>
								<?php endif; ?>
								<td class='status-carga'>
									<i class='fas fa-circle-notch fa-spin'></i>
									<p>Verificando status.</p>
								</td>
								<td>
									<input type='checkbox' value=<?=$caixa['caixa']?> name='caixa-selecionado'/>
								</td>
					      	</tr>
					    <?php endforeach; ?>
				    </tbody>
				<?php endif; ?>
			</table>
			<?php if (empty($caixas)): ?>
				<div class='text-center data-not-found'>
					<h4>Nenhum caixa cadastrado. <i class='far fa-frown'></i></h4>
				</div>		    	
			<?php endif; ?>
		</div>
		<div class='row'>
			<div class='col-sm-8 col-sm-offset-2 text-center carga-seletores'>
				<div class='col-sm-4 col-xs-4'>
					<input type='radio' id='select' name='selecionar-caixas'/> 
					<strong>Selecionar Todos.</strong>
				</div>
				<div class='col-sm-4 col-xs-4'>
					<input type='radio' id='invert' name='selecionar-caixas'/> 
					<strong>Inverter Seleção.</strong>
				</div>
				<div class='col-sm-4 col-xs-4'>
					<input type='radio' id='deselect' name='selecionar-caixas' checked/> 
					<strong>Desmarcar Todos.</strong>
				</div>
			</div>
		</div>
	</div>
</div>