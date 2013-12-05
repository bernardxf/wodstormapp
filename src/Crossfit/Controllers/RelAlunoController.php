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
	public static function carregaRelAluno(Application $app)
	{
		$response = new Response();

		$selectAluno = Aluno::retornaTodosSimples();

		$response->setData($selectAluno);

		return $response->getAsJson();
	}
}