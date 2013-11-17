<?php
namespace Crossfit\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Crossfit\Dados\Usuario;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllerCollection = $app['controllers_factory'];
		
		// Retorna usuario selecionado
		$controllerCollection->get('/{id_usuario}', function($id_usuario) use ($app){
			$resultado = Usuario::retornaSelecionado($id_usuario);
			return new Response(json_encode($resultado), 200);
			// return new Response(json_encode($resultado), 200, array('Access-Control-Allow-Origin' => '*', 'Content-Type' => 'application/json'));
		});

		$controllerCollection->post('/{usuario}', function($usuario){
			$resultado = Usuario::retornaSelecionado($usuario);
			return new Response(json_encode($resultado), 200);
		});

		$controllerCollection->post('/', function(){
			$resultado = Usuario::retornaTodos();
			return new Response(json_encode($resultado), 200);
		});

		return $controllerCollection;		
	}
}	