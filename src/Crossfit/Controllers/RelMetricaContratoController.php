<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Contrato;
use Crossfit\Util\Response;
use Crossfit\App;


class RelMetricaContratoController
{
	public static function relatorioMensalContratos(Request $request)
	{
		$response = new Response();
		$dadosPesquisa = json_decode($request->getContent());

		$resultado = Contrato::retornaRelatorioMensalContratos($dadosPesquisa->data_ini, $dadosPesquisa->data_fim);
		$response->setData($resultado);

		return $response->getAsJson();
	}
}