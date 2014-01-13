<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\FormaPagamento;
use Crossfit\Util\Response;
use Silex\Application;

class FormaPagamentoController
{
	public static function carregaFormaPagamento(Application $app)
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
		$formapagamentoDataset = json_decode($request->getContent(), true);

		$formapagamentoDataset = ['id_organizacao'] = App::getSession()->get('organizacao');

		FormaPagamento::salvaFormaPagamento($formapagamentoDataset);		

		return $response->getAsJson();
	}

	public static function atualizaFormaPagamento($id_forma_pagamento, Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(), true);

		FormaPagamento::atualizaFormaPagamento($formapagamentoDataset, $id_forma_pagamento);
		
		return $response->getAsJson();
	}

	public static function removeFormaPagamento($id_forma_pagamento)
	{
		$response = new Response();

		FormaPagamento::removeFormaPagamento($id_forma_pagamento);
		
		return $response->getAsJson();
	}
}