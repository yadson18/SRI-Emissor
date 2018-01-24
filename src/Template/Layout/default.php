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
		<?= $this->Html->script('jquery.mask.js') ?>
		<?= $this->Html->script('jquery.cpfcnpj.min.js') ?>
		<?= $this->Html->script('jquery-datetimepicker.min.js') ?>
		<?= $this->Html->script('internal-functions.js') ?>
		
		<?= $this->Html->less('mixin.less') ?>
		<?= $this->Html->script(
				strtolower($this->fetch('controller')) . '-' . 
				strtolower($this->fetch('view')) . '.js'
			) 
		?>
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
			        			<a href='/Page/home'>Home</a>
			        		</li>
			        		<li>
			        			<a href='/Cadastro/index'>Destinatários</a>
			        		</li>
			        		<li class='dropdown'>
							    <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
							    	Produtos <span class='caret'></span>
							    </a>
							    <ul class='dropdown-menu'>
							    	<li>
							        	<a href='/Produto/index'>Cadastrados</a>
							        </li>
							        <li>
							        	<a href='#'>Enviar Carga</a>
							        </li>
							        <li>												
							          	<a href='#'>Grupos</a>
							        </li>
							    </ul>
			        		</li>
			        		<li><a href='#'>NF-e</a></li>
			        		<li><a href='#'>Gerencial</a></li>
			        	</ul>
			        	<ul class='nav navbar-nav navbar-right'>
		        			<li class='dropdown'>
						        <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
						        	<i class='fas fa-user'></i>
		            				Bem-vindo <?= $usuarioNome ?> <span class='caret'></span>
						        </a>
						        <ul class='dropdown-menu'>
						          	<li>
						          		<a href='#'>
						          			Modificar Senha <i class='fas fa-key'></i>
						          		</a>
						          	</li>
						          	<li>															
						          		<a href='/Colaborador/logout'>
						          			Sair <i class='fas fa-sign-out-alt'></i> 
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
					            <i class='fas fa-map-marker-alt' aria-hidden='true'></i> 
					            Find Us
					        </p> 
					    </a>
					</div>
					<div class='col-sm-3'>
					    <a href='https://www.facebook.com/' target='blank'>
					        <p>
					            <i class='fab fa-facebook-square' aria-hidden='true'></i> 
					            Facebook
					        </p> 
					    </a>
					</div>
					<div class='col-sm-3'>
					 	<a>
					    	<p>
					    		<i class='fas fa-envelope' aria-hidden='true'></i>
					    		email@email.com
					    	</p>
					    </a>
					</div>
					<div class='col-sm-3'>
					   	<a>
					    	<p>
					    		<i class='fas fa-phone-square' aria-hidden='true'></i>
					            (81) 99999-9999
					    	</p>
					    </a>
					</div>
				</div>
			</footer>
		<?php endif ?>
	</body>
</html>