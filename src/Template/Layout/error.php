<!DOCTYPE html>
<html lang="pt-br">
    <head>
    	<title><?= $this->fetch('appName') . $this->fetch('title') ?></title>
        
    	<meta name='viewport' content='width=device-width, initial-scale=1'>
        <?= $this->Html->encoding() ?>

        <?= $this->Html->css('bootstrap.min.css') ?>
        <?= $this->Html->css('font-awesome.min.css') ?>

        <?= $this->Html->script('jquery.min.js') ?>
        <?= $this->Html->script('bootstrap.min.js') ?>
    </head>
    <body>
    	<div class='container'>
            <div class='header'>
                <h1>Error</h1>
            </div>
            <div class='content'> 
                <?= $this->fetch('content') ?>
            </div>
       	</div>
    </body>
</html>