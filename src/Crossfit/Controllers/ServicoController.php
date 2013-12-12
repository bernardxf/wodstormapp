<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Servico;
use Crossfit\Dados\Aluno;
use Crossfit\Util\Response;
use Silex\Application;
use Crossfit\App;

class ServicoController
{
	public static function carregaServico(Application $app)
	{
		$response = new Response();
		
		$servico = Servico::retornaTodos();
		$selectAluno = Aluno::retornaTodosSimples();
		
		$response->setData(array("servico" => $servico, "selectAluno" => $selectAluno));	
		
		return $response->getAsJson();
	}

	public static function carregaCadServico($id_servico)
	{
		$response = new Response();
		
		$servico = Servico::retornaSelecionado($id_servico);
		$selectAluno = Aluno::retornaTodosSimples();
		
		$response->setData(array("servico" => $servico, "selectAluno" => $selectAluno));	
		
		return $response->getAsJson();
	}

	public static function salvaServico(Request $request)
	{
		$response = new Response();
		
		$dataset = json_decode($request->getContent());

		$servicoDataset = [
			'tipo' => $dataset->tipo,
			'valor' => $dataset->valor,
			'descricao' => $dataset->descricao,
			'id_aluno' => $dataset->id_aluno,
			'id_organizacao' => App::getSession()->get('organizacao')
		];

		Servico::salvaServico($servicoDataset);		
		
		return $response->getAsJson();
	}

	public static function atualizaServico($id_servico, Request $request)
	{
		$response = new Response();
		
		$dataset = json_decode($request->getContent());

		$servicoDataset = [
			'tipo' => $dataset->tipo,
			'valor' => $dataset->valor,
			'descricao' => $dataset->descricao,
			'id_aluno' => $dataset->id_aluno
		];		

		Servico::atualizaServico($servicoDataset, $id_servico);
		
		return $response->getAsJson();
	}

	public static function removeServico($id_servico)
	{
		$response = new Response();
		
		Servico::removeServico($id_servico);
		
		return $response->getAsJson();
	}
}