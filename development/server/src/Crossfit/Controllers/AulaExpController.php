<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\AulaExp;
use Crossfit\Util\Response;
use Crossfit\App;
use Silex\Application;

class AulaExpController
{
	public static function carregaAulaExp(Application $app)
	{
		$response = new Response();

		$resultado = AulaExp::retornaTodos();

		$response->setData($resultado);

		return $response->getAsJson();
	}

	public static function carregaCadAulaExp($id_aulaexp)
	{
		$response = new Response();

		$resultado = AulaExp::retornaSelecionado($id_aulaexp);

		$response->setData($resultado);

		return $response->getAsJson(); 
	}

	public static function salvaAulaExp(Request $request)
	{
		$response = new Response();
		$aulaexpDataset = json_decode($request->getContent(), true);

		$aulaexpDataset['id_organizacao'] = App::getSession()->get('organizacao');

		AulaExp::salvaAulaExp($aulaexpDataset);		

		return $response->getAsJson();
	}

	public static function atualizaAulaExp($id_aulaexp, Request $request)
	{
		$response = new Response();
		$aulaexpDataset = json_decode($request->getContent(), true);

		$resultado = AulaExp::atualizaAulaExp($aulaexpDataset, $id_aulaexp);
		
		return $response->getAsJson();
	}

	public static function removeAulaExp($id_aulaexp)
	{
		$response = new Response();

		AulaExp::removeAulaExp($id_aulaexp);

		return $response->getAsJson();
	}
}