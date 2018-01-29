<?php 
	function precoSugerido($preco, $markup)
	{
		return number_format(($preco + ($preco * ($markup / 100))), 2);
	}

	function dinheiroParaFloat($number)
	{
		return preg_replace(['/[.]/', '/[,]/'], ['', '.'], $number);
	}