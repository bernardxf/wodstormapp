<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\AgrupadorFinanceiro;
use Crossfit\Util\Response;
use Crossfit\App;

class AgrupadorFinanceiroController
{
	public static function retornaTodos()
	{
		$response = new Response();
		$categorias = AgrupadorFinanceiro::retornaTodos();

		$response->setData(array('categorias' => $categorias));

		return $response->getAsJson();
	}

	public static function salvaAgrupador(Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(),true);
		$dataset['id_organizacao'] = App::getSession()->get('organizacao');

		$resultado = AgrupadorFinanceiro::salvaAgrupador($dataset);

		$response->setData($resultado);

		return $response->getAsJson();
	}
}