<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\AulaExp;
use Crossfit\Util\Response;
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
		$dataset = json_decode($request->getContent());

		$aulaexpDataset = [
			'nome' => $dataset->nome,
			'data_aula' => $dataset->data_aula,
			'telefone' => $dataset->telefone,
			'email' => $dataset->email,
			'confirmado' => $dataset->confirmado,
			'presente' => $dataset->presente,
			'id_organizacao' => App::getSession()->get('organizacao')
		];

		AulaExp::salvaAulaExp($aulaexpDataset);		

		return $response->getAsJson();
	}

	public static function atualizaAulaExp($id_aulaexp, Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent());

		$aulaexpDataset = [
			'nome' => $dataset->nome,
			'data_aula' => $dataset->data_aula,
			'telefone' => $dataset->telefone,
			'email' => $dataset->email,
			'confirmado' => $dataset->confirmado,
			'presente' => $dataset->presente
		];		

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