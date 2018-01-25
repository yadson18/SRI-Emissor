<?php 
	function precoSugerido($preco, $markup)
	{
		return number_format(($preco + ($preco * ($markup / 100))), 2);
	}

	function normalizarDadosProduto(array $dadosProduto)
	{
		$resultado = array_map(function($coluna, $valor) {
			if ($coluna === 'compra' || $coluna === 'venda' ||
				$coluna === 'preco_vol' || $coluna === 'preco_prom'
			) {
				return dinheiroParaFloat($valor);
			}
			else if ($coluna === 'data_inicio_prom' || 
				$coluna === 'data_final_prom'
			) {
				return str_replace('/', '.', $valor);
			}
			else {
				return removeSpecialChars($valor);
			}
		}, array_keys($dadosProduto), array_values($dadosProduto));

		return array_combine(array_keys($dadosProduto), $resultado);
	}

	function dinheiroParaFloat($number)
	{
		return preg_replace(['/[.]/', '/[,]/'], ['', '.'], $number);
	}