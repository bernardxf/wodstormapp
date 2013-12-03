<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\FormaPagamento;
use Crossfit\Util\Response;

class FormaPagamentoController
{
	public static function carregaFormaPagamento()
	{
		$response = new Response();

		$resultado = FormaPagamento::retornaTodos();

		$response->setData($resultado);

		return $response->getAsJson();
	}

	public static function carregaCadFormaPagamento($id_forma_pagamento)
	{
		$response = new Response();

		$resultado = FormaPagamento::retornaSelecionado($id_forma_pagamento);

		$response->setData($resultado);

		return $response->getAsJson();
	}

	public static function salvaFormaPagamento(Request $request)
	{
		$response = new Response(); 
		$dataset = json_decode($request->getContent());

		$formapagamentoDataset = [
			'nome' => $dataset->nome
		];

		FormaPagamento::salvaFormaPagamento($formapagamentoDataset);		

		return $response->getAsJson();
	}

	public static function atualizaFormaPagamento($id_forma_pagamento, Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent());

		$formapagamentoDataset = [
			'nome' => $dataset->nome
		];		

		$resultado = FormaPagamento::atualizaFormaPagamento($formapagamentoDataset, $id_forma_pagamento);
		
		return $response->getAsJson();
	}

	public static function removeFormaPagamento($id_forma_pagamento)
	{
		$response = new Response();

		FormaPagamento::removeFormaPagamento($id_forma_pagamento);
		
		return $response->getAsJson();
	}
}