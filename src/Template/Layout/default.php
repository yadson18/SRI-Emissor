<!DOCTYPE html>
<html lang='pt-br'>
	<head>
		<title>
			<?= $this->fetch('appName') ?> - <?= $this->fetch('title') ?>
		</title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>

		<?= $this->Html->encoding() ?>

		<?= $this->Html->font('Montserrat') ?>
		<?= $this->Html->css('bootstrap.min.css') ?>
		<?= $this->Html->css('fontawesome-all.min.css') ?>
		<?= $this->Html->css('jquery-datetimepicker.min.css') ?>
		
		<?= $this->Html->script('jquery.min.js') ?>
		<?= $this->Html->script('bootstrap.min.js') ?>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/chroma-js/1.3.6/chroma.min.js'></script>
		<?= $this->Html->script('jquery-mask.min.js') ?>
		<?= $this->Html->script('jquery-mask-money.min.js') ?>
		<?= $this->Html->script('jquery.cpfcnpj.min.js') ?>
		<?= $this->Html->script('jquery-datetimepicker.min.js') ?>
		<?= $this->Html->script('internal-functions.js') ?>
		
		<?= $this->Html->less('mixin.less') ?>
		<?= $this->Html->script($this->fetch('controller') . '.js') ?>
		<?= $this->Html->less(
				strtolower($this->fetch('controller')) . '-' . 
				strtolower($this->fetch('view')) . '.less'
			) 
		?>
		<?= $this->Html->script('less.min.js') ?>
	</head>
	<body>	
		<nav class='navbar navbar-inverse' id='main-nav'>
		    <div class='container-fluid'>
		        <div class='navbar-header'>
		            <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#responsive-menu' aria-expanded='false'>
		                <span class='sr-only'>Toggle navigation</span>
		                <span class='icon-bar'></span>
		                <span class='icon-bar'></span>
		                <span class='icon-bar'></span>
		            </button>
		        </div>
		        <div class='collapse navbar-collapse' id='responsive-menu'>
		        	<?php 
		            	if ($this->fetch('controller') === 'Page' &&
		            		$this->fetch('view') === 'index'
		            	): 
		            ?>
		            	<ul class='nav navbar-nav navbar-right'>
		            		<li>
		            			<a href='#' data-toggle='modal' data-target='#login'>
				            		Fazer Login <i class='fas fa-sign-in-alt'></i> 
				            	</a>
		            		</li>
		            	</ul>
		        	<?php else: ?>
			        	<ul class='nav navbar-nav'>
			        		<li>
			        			<a href='/Page/home'><i class='fas fa-home'></i> Início</a>
			        		</li>
			        		<li>
			        			<a href='/Cadastro/index'>
			        				<i class='fas fa-users'></i> Destinatários
			        			</a>
			        		</li>
			        		<li class='dropdown'>
							    <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
							    	<i class='fas fa-cubes'></i>
							    	Produtos <span class='caret'></span>
							    </a>
							    <ul class='dropdown-menu'>
							    	<li>
							        	<a href='/Produto/index'>
							        		<i class='fas fa-save'></i> Cadastrados
							        	</a>
							        </li>
							        <li>
							        	<a href='/Produto/carga'>
							        		<i class='fas fa-truck'></i> Enviar Carga
							        	</a>
							        </li>
							        <li>												
							          	<a href='/GrupoProd/index'>
							          		<i class='fas fa-th-large'></i> Grupos
							          	</a>
							        </li>
							    </ul>
			        		</li>
			        		<li>
			        			<a href='#'><i class='fas fa-file-alt'></i> NF-e</a>
			        		</li>
			        		<li>
			        			<a href='#'><i class='fas fa-chart-line'></i> Gerencial</a>
			        		</li>
			        	</ul>
			        	<ul class='nav navbar-nav navbar-right'>
		        			<li class='dropdown'>
						        <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
						        	<i class='fas fa-user'></i>
		            				<?= $usuarioNome ?> <span class='caret'></span>
						        </a>
						        <ul class='dropdown-menu'>
						          	<li>
						          		<a href='#'>
						          			<i class='fas fa-key'></i> Modificar Senha
						          		</a>
						          	</li>
						          	<li>
					        			<a href='#'>
					        				<i class='fas fa-cogs'></i> Configurações
					        			</a>
					        		</li>
						          	<li>
						          		<a href='/Colaborador/logout'>
						          			<i class='fas fa-sign-out-alt'></i> Sair
						          		</a>
						          	</li>
						        </ul>
						    </li>
						</ul>
			        <?php endif; ?>
		        </div>
		    </div>
		</nav>
		<div class='content col-sm-12'>
			<?= $this->fetch('content') ?>
		</div>
		<?php 
			if ($this->fetch('controller') === 'Page' &&
				$this->fetch('view') === 'index'
			): 
		?>
			<footer id='footer' class='col-sm-12'>
				<div class='contact'>
					<div class='col-sm-3'>
					    <a href='#' target='blank'>
					        <p>
					            <i class='fas fa-map-marker-alt'></i> Find Us
					        </p> 
					    </a>
					</div>
					<div class='col-sm-3'>
					    <a href='https://www.facebook.com/' target='blank'>
					        <p>
					            <i class='fab fa-facebook-f'></i> Facebook
					        </p> 
					    </a>
					</div>
					<div class='col-sm-3'>
					 	<a>
					    	<p>
					    		<i class='fas fa-envelope'></i> email@email.com
					    	</p>
					    </a>
					</div>
					<div class='col-sm-3'>
					   	<a>
					    	<p>
					    		<i class='fas fa-phone'></i> (81) 99999-9999
					    	</p>
					    </a>
					</div>
				</div>
				<div class='copy'>
					<strong><i class='far fa-copyright'></i></strong> SRI Automação
				</div>
			</footer>
		<?php endif ?>
	</body>
</html>