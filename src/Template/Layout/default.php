<!DOCTYPE html>
<html lang='pt-br'>
	<head>
		<title><?= $this->fetch('appName') . $this->fetch('title') ?></title>
		
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<?= $this->Html->encoding() ?>

		<?= $this->Html->css('bootstrap.min.css') ?>
		<?= $this->Html->css('fontawesome-all.min.css') ?>

		<?= $this->Html->less('mixin.less') ?>
		
		<?= $this->Html->script('jquery.min.js') ?>
		<?= $this->Html->script('bootstrap.min.js') ?>

		<?= $this->Html->less('home.less') ?>
		<?= $this->Html->script('less.min.js') ?>
	</head>
	<body>	
		<nav class='navbar navbar-default navbar-fixed-top' id='main-nav'>
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
		            <ul class='nav navbar-nav navbar-right'>
		            	<li>
		            		<a href='#' data-toggle='modal' data-target='#login'>
		            			Fazer Login <i class="fas fa-sign-in-alt"></i> 
		            		</a>
		            	</li>
		            </ul>
		        </div>
		    </div>
		</nav>
		<div class='content'>
			<?= $this->fetch('content') ?>
		</div>
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
	</body>
</html>