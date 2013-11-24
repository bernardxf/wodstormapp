<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Plano;
use Crossfit\Util\Response;

class PlanoController
{
	public static function carregaPlano()
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
		$dataset = json_decode($request->getContent());

		$planoDataset = [
			'nome' => $dataset->nome,
			'tipo' => $dataset->tipo,
			'valor' => $dataset->valor
		];

		$response = new Response();

		if($dataset->id_plano){
			Plano::atualizaPlano($planoDataset, $dataset->id_plano);
		} else {
			Plano::salvaPlano($planoDataset);	
		}
		

		return $response->getAsJson();
	}

	public static function removePlano($id_plano)
	{
		$response = new Response();

		Plano::removePlano($id_plano);

		return $response->getAsJson();
	}
}