<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Estacionamento;
use Crossfit\Dados\Aluno;
use Crossfit\Util\Response;
use Silex\Application;
use Crossfit\App;

class EstacionamentoController
{
	public static function carregaEstacionamento(Application $app)
	{
		$response = new Response();

		$estacionamento = Estacionamento::retornaTodos();
		$selectAluno = Aluno::retornaTodosSimples();

		$response->setData(array("estacionamento" => $estacionamento, "selectAluno" => $selectAluno));

		return $response->getAsJson();
	}

	public static function carregaCadEstacionamento($id_estacionamento)
	{
		$response = new Response();

		$estacionamento = Estacionamento::retornaSelecionado($id_estacionamento);
		$selectAluno = Aluno::retornaTodosSimples();

		$response->setData(array("estacionamento" => $estacionamento, "selectAluno" => $selectAluno));

		return $response->getAsJson();
	}

	public static function salvaEstacionamento(Request $request)
	{
		$response = new Response();
		$estacionamentoDataset = json_decode($request->getContent(), true);

		$estacionamentoDataset = array(
			'id_organizacao' => App::getSession()->get('organizacao')
		);	

		$resultado = Estacionamento::salvaEstacionamento($estacionamentoDataset);

		return $response->getAsJson();
	}

	public static function atualizaEstacionamento($id_estacionamento, Request $request)
	{
		$response = new Response();
		$estacionamentoDataset = json_decode($request->getContent(), true);

		$resultado = Estacionamento::atualizaEstacionamento($estacionamentoDataset, $id_estacionamento);

		return $response->getAsJson();
	}

	public static function removeEstacionamento($id_estacionamento)
	{
		$response = new Response();

		$resultado = Estacionamento::removeEstacionamento($id_estacionamento);

		return $response->getAsJson();
	}
}