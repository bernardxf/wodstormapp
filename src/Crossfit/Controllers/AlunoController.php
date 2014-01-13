<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Aluno;
use Crossfit\Util\Response;
use Crossfit\App;

class AlunoController
{
	public static function carregaAluno(Request $request)
	{
		$response = new Response();
		$nome = $request->query->get('nome');

		if($nome){
			$resultado = Aluno::retornaTodosFiltradoPorNome($nome);
		} else {
			$resultado = Aluno::retornaTodos();	
		}

		$response->setData($resultado);

		return $response->getAsJson();
	}

	public static function carregaCadAluno($id_aluno)
	{
		$response = new Response();

		$resultado = Aluno::retornaSelecionado($id_aluno);

		$response->setData($resultado);

		return $response->getAsJson();
	}

	public static function salvaAluno(Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(), true);
		$dataset['id_organizacao'] = App::getSession()->get('organizacao');

		$resultado = Aluno::salvaAluno($dataset);

		$response->setData($resultado);

		return $response->getAsJson();
	}

	public static function atualizaAluno($id_aluno, Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(), true);

		$resultado = Aluno::atualizaAluno($id_aluno, $dataset);

		return $response->getAsJson();
	}

	public static function removeAluno($id_aluno)
	{
		$response = new Response();

		$resultado = Aluno::removeAluno($id_aluno);

		return $response->getAsJson();
	}
}