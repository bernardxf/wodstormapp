<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\AlunoAula;
use Crossfit\Dados\Aula;
use Crossfit\Util\Response;

class PresencaController
{
	public static function retornaAula(Request $request)
	{
		$response = new Response();
		$data = $request->query->get('data');

		if($data){
			$resultado = AlunoAula::retornaSelecionadoPorData($data);
		} else {
			$resultado = AlunoAula::retornaTodos();
		}

		$response->setData($resultado);
		return $response->getAsJson();
	}

	public static function retornaPresencaAtiva()
	{
		$response = new Response();
		$resultado = AlunoAula::retornaPresencaAtiva();

		$response->setData($resultado);
		return $response->getAsJson();
	}

	public static function retornaCadPresenca($id_aula)
	{
		$response = new Response();

		$aula = Aula::retornaSelecionado($id_aula);
		$presenca = AlunoAula::retornaSelecionado($id_aula);

		$response->setData(array('aula' => $aula, 'presenca' => $presenca));

		return $response->getAsJson();
	}

	public static function salvaPresenca(Request $request)
	{
		$response = new Response();
		$presencaDataset = json_decode($request->getContent());

		AlunoAula::salvaPresenca($presencaDataset);

		return $response->getAsJson();
	}

	public static function atualizaPresenca($id_aula, Request $request)
	{
		$response = new Response();
		$presencaDataset = json_decode($request->getContent());

		AlunoAula::atualizaPresenca($id_aula, $presencaDataset);

		return $response->getAsJson();
	}

	public static function removePresenca($id_aula)
	{
		$response = new Response();

		$resultado = AlunoAula::removeAlunosAula($id_aula);

		return $response->getAsJson();
	}

	public static function salvarPresencaSalao(Request $request)
	{
		$response = new Response();
		$presencaDataset = json_decode($request->getContent());

		return $response->getAsJson();
	}

	public static function salvarAlunoPresenteSalao($id_aula, Request $request)
	{
		$response = new Response();
		$presenteDataset = json_decode($request->getContent());

		AlunoAula::atualizaPresencaSalao($id_aula, $presenteDataset);

		return $response->getAsJson();
	}
}