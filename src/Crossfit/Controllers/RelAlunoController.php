<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Aluno;
use Crossfit\Dados\AlunoAula;
use Crossfit\Dados\RelAluno;
use Crossfit\Util\Response;
use Silex\Application;
use Crossfit\App;

class RelAlunoController
{
	public static function carregaRelAluno()
	{
		$response = new Response();

		$resultado = Aluno::retornaTodosSimples();

		$response->setData($resultado);

		return $response->getAsJson();

	}

	public static function pesquisaRelAluno($id_aluno, $data_ini, $data_fim)
	{
		$response = new Response();

		$resultado = RelAluno::retornaSelecionado($id_aluno, $data_ini, $data_fim);

		$response->setData($resultado);

		return $response->getAsJson();
	}
}