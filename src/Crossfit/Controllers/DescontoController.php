<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Desconto;
use Crossfit\Util\Response;
use Crossfit\App;
use Silex\Application;

class DescontoController
{
	public static function carregaDesconto(Application $app)
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
		$descontoDataset = json_decode($request->getContent(), true);

		$descontoDataset['id_organizacao'] = App::getSession()->get('organizacao');

		Desconto::salvaDesconto($descontoDataset);		

		return $response->getAsJson();
	}

	public static function atualizaDesconto($id_desconto, Request $request)
	{
		$response = new Response();
		$descontoDataset = json_decode($request->getContent(), true);

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