<div class='col-sm-12' id='carga'>
	<h2 class='page-header'>
		Carga de Produto
		<button class='btn btn-primary enviar-carga' value='Alterados'>
			Carga Parcial <i class='fas fa-plus-circle'></i>
		</button>
		<button class='btn btn-success enviar-carga' value='Geral'>
			Carga Geral <i class='fas fa-plus-circle'></i>
		</button>
	</h2>
	<div id='message-box'></div>
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
		    <?php if(!empty($caixas)): ?>
			    <tbody class='text-capitalize'>
			    		<?php foreach($caixas as $index => $caixa): ?>
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
									<p><strong>Verificando status.</strong></p>
								</td>
								<td><input type='checkbox' value=<?=$caixa['caixa']?> name='caixa-selecionado'/></td>
				      		</tr>
				      	<?php endforeach; ?>
			    </tbody>
			<?php endif; ?>
		</table>
		<?php if(empty($caixas)): ?>
			<div class='text-center data-not-found'>
				<h4>Nenhum caixa cadastrado. <i class='far fa-frown'></i></h4>
			</div>		    	
		<?php endif; ?>
	</div>
	<div class='col-sm-8 col-sm-offset-2 text-center'>
		<div class='col-sm-4 col-xs-4'>
			<input type='radio' id='select' name='selecionar-caixas'/> Selecionar Todos.
		</div>
		<div class='col-sm-4 col-xs-4'>
			<input type='radio' id='invert' name='selecionar-caixas'/> Inverter Seleção.
		</div>
		<div class='col-sm-4 col-xs-4'>
			<input type='radio' id='deselect' name='selecionar-caixas' checked/> Desmarcar Todos.
		</div>
	</div>
</div>