<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\RelPresenca;
use Crossfit\Util\Response;
use Crossfit\App;


class RelPresencaController
{
	public static function pesquisaRelPresenca(Request $request)
	{
		$response = new Response();
		$dadosPesquisa = json_decode($request->getContent());

		$resultado = RelPresenca::retornaSelecionados($dadosPesquisa->data_ini, $dadosPesquisa->data_fim);
		$response->setData($resultado);

		return $response->getAsJson();
	}
}