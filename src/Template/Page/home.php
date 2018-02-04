<div id='home' class='col-sm-12'>
	<h2 class='page-header text-capitalize'>
		Dashboard:
	    <small>
	       	<?= mb_strtolower($usuarioRazao) ?> -
	       	<?= mask('##.###.###/####-##', $usuarioCnpj) ?>
	    </small>
    </h2>
    <div id='cards'>
	    <div class='card col-md-3'>
	    	<div class='card-content'>
	    		<div class='card-header text-center'>
	    			<h4>NF-e</h4>
	    		</div>
	    		<div class='card-body'>
	    			<ul class='list-group'>
	    				<li class='list-group-item text-center'>
	    					<strong>Emitidas</strong>
	    				</li>
	    				<li class='list-group-item'>
	    					Hoje 
	    					<span class='badge thousand'><?= $nfeEmitidas->hoje ?></span>
	    				</li>
	    				<li class='list-group-item'>
	    					Total 
	    					<span class='badge thousand'><?= $nfeEmitidas->total ?></span>
	    				</li>
	    			</ul>
	    			<div class='text-center'>
	    				<a href='#' class='btn btn-warning form-control'>
	    					Detalhado <i class='fas fa-angle-double-right'></i>
	    				</a>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	    <div class='card col-md-3'>
	    	<div class='card-content'>
	    		<div class='card-header text-center'>
	    			<h4>NFC-e</h4>
	    		</div>
	    		<div class='card-body'>
	    			<ul class='list-group'>
	    				<li class='list-group-item text-center'>
	    					<strong>Emitidas</strong>
	    				</li>
	    				<li class='list-group-item'>
	    					Hoje <span class='badge thousand'>0</span>
	    				</li>
	    				<li class='list-group-item'>
	    					Total <span class='badge thousand'>0</span>
	    				</li>
	    			</ul>
	    			<div class='text-center'>
	    				<a href='#' class='btn btn-info form-control'>
	    					Detalhado <i class='fas fa-angle-double-right'></i>
	    				</a>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	    <div class='card col-md-3'>
	    	<div class='card-content'>
	    		<div class='card-header text-center'>
	    			<h4>NFS-e</h4>
	    		</div>
	    		<div class='card-body'>
	    			<ul class='list-group'>
	    				<li class='list-group-item text-center'>
	    					<strong>Emitidas</strong>
	    				</li>
	    				<li class='list-group-item'>
	    					Hoje <span class='badge thousand'>0</span>
	    				</li>
	    				<li class='list-group-item'>
	    					Total <span class='badge thousand'>0</span>
	    				</li>
	    			</ul>
	    			<div class='text-center'>
	    				<a href='#' class='btn btn-danger form-control'>
	    					Detalhado <i class='fas fa-angle-double-right'></i>
	    				</a>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	    <div class='card col-md-3'>
	    	<div class='card-content'>
	    		<div class='card-header text-center'>
	    			<h4>Produtos</h4>
	    		</div>
	    		<div class='card-body'>
	    			<ul class='list-group'>
	    				<li class='list-group-item text-center'>
	    					<strong>Cadastrados</strong>
	    				</li>
	    				<li class='list-group-item'>
	    					Hoje 
	    					<span class='badge thousand'>
	    						<?= $produtosCadastrados->hoje ?>
	    					</span>
	    				</li>
	    				<li class='list-group-item'>
	    					Total 
	    					<span class='badge thousand'>
	    						<?= $produtosCadastrados->total ?>
	    					</span>
	    				</li>
	    			</ul>
	    			<div class='text-center'>
	    				<a href='/Produto/index' class='btn btn-success form-control'>
	    					Detalhado <i class='fas fa-angle-double-right'></i>
	    				</a>
	    			</div>
	    		</div>
	    	</div>
	    </div>
    </div>
</div>