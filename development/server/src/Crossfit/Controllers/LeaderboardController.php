<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Leaderboard;
use Crossfit\Util\Response;
use Crossfit\App;

class LeaderboardController
{
	// retorna a lista com os liderboards de acordo com as datas que os resultados foram postados.
	public static function retornaTodos()
	{
		$response = new Response();
		$resultado = Leaderboard::retornaListaDatas();

		$response->setData($resultado);
		return $response->getAsJson();
	}

	// retorna a lista de resultados de um leaderboard expecifico.
	public static function retornaResultadosLeaderboard(Request $request, $data)
	{	
		$id_organizacao = $request->query->get('organizacao');
		$response = new Response();

		if($id_organizacao) {
			$resultado = Leaderboard::retornaLeaderboardPorDataEOrganizacao($data, $id_organizacao);
		} else {
			$resultado = Leaderboard::retornaLeaderboardPorData($data);
		}

		$response->setData($resultado);
		return $response->getAsJson();		
	}

	// salvar o resultado inserido por algum atleta no leaderboard.
	public static function salvarResultado(Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(), true);

		// Caso esta sendo salvo apartir da tela de leaderboard do dia
		// aplica a data atual ao dataset.
		if(array_key_exists('data', $dataset) == false) $dataset['data'] = date('Y-m-d');

		$dataset['id_organizacao'] = App::getSession()->get('organizacao');
		$resultado = Leaderboard::salvaResultado($dataset);

		$response->setData($resultado);
		return $response->getAsJson();
	}
}