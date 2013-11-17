<?php
namespace Crossfit\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Crossfit\Dados\Aluno;

class AlunoController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllerCollection = $app['controllers_factory'];
		
		// Retorna a lista de todos os alunos cadastrados
		$controllerCollection->get('/', function() use ($app){
			$resultado = Aluno::retornaTodos();
			return new Response(json_encode($resultado));
		});

		// Retorna dataset com apenas id_aluno e nome
		$controllerCollection->get('/simples', function() use ($app){
			$resultado = Aluno::retornaTodosSimples();
			return new Response(json_encode($resultado));
		});


		// Retorna o aluno baseado no id passado
		$controllerCollection->get('/{id_aluno}', function($id_aluno) use ($app){
			$resultado = Aluno::retornaSelecionado($id_aluno);
			return new Response(json_encode($resultado));
		});
		

		return $controllerCollection;		
	}
}	