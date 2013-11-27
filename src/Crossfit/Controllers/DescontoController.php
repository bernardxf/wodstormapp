<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Desconto;
use Crossfit\Util\Response;

class DescontoController
{
	public static function carregaDesconto()
	{
		$response = new Response();

		$resultado = Desconto::retornaTodos();

		$response->setData($resultado);

		return $response->getAsJson();
	}

	public static function carregaCadDesconto($id_desconto)
	{
		$response = new Response();

		$resultado = Desconto::retornaSelecionado($id_desconto);

		$response->setData($resultado);

		return $response->getAsJson();
	}

	public static function salvaDesconto(Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent());

		$descontoDataset = [
			'nome' => $dataset->nome,
			'porc_desc' => $dataset->porc_desc
		];

		Desconto::salvaDesconto($descontoDataset);		

		return $response->getAsJson();
	}

	public static function atualizaDesconto($id_desconto, Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent());

		$descontoDataset = [
			'nome' => $dataset->nome,
			'porc_desc' => $dataset->porc_desc
		];

		Desconto::atualizaDesconto($descontoDataset, $id_desconto);		

		return $response->getAsJson();
	}

	public static function removeDesconto($id_desconto)
	{
		$response = new Response();

		Desconto::removeDesconto($id_desconto);

		return $response->getAsJson();
	}
}