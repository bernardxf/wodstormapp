<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Plano;
use Crossfit\Util\Response;
use Silex\Application;

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
		$dataset = json_decode($request->getContent());

		$planoDataset = [
			'nome' => $dataset->nome,
			'tipo' => $dataset->tipo,
			'valor' => $dataset->valor
		];

		Plano::salvaPlano($planoDataset);		

		return $response->getAsJson();
	}

	public static function atualizaPlano($id_plano, Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent());

		$planoDataset = [
			'nome' => $dataset->nome,
			'tipo' => $dataset->tipo,
			'valor' => $dataset->valor
		];		

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