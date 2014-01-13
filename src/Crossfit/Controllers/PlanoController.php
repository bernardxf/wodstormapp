<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Plano;
use Crossfit\Util\Response;
use Silex\Application;
use Crossfit\App;

class PlanoController
{
	public static function carregaPlano(Application $app)
	{
		$response = new Response();

		$resultado = Plano::retornaTodos();

		$response->setData($resultado);

		return $response->getAsJson();
	}

	public static function carregaCadPlano($id_plano)
	{
		$response = new Response();

		$resultado = Plano::retornaSelecionado($id_plano);
		
		$response->setData($resultado);	

		return $response->getAsJson();
	}

	public static function salvaPlano(Request $request)
	{
		$response = new Response();
		$planoDataset = json_decode($request->getContent(), true);

		$planoDataset['id_organizacao'] = App::getSession()->get('organizacao');

		Plano::salvaPlano($planoDataset);		

		return $response->getAsJson();
	}

	public static function atualizaPlano($id_plano, Request $request)
	{
		$response = new Response();
		$planoDataset = json_decode($request->getContent(), true);

		Plano::atualizaPlano($planoDataset, $id_plano);
		
		return $response->getAsJson();
	}

	public static function removePlano($id_plano)
	{
		$response = new Response();

		Plano::removePlano($id_plano);

		return $response->getAsJson();
	}
}