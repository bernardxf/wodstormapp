<?php
namespace Crossfit\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Crossfit\Conexao;
use Crossfit\Util\Response;
use Crossfit\Dados\Usuario;

class LoginController
{
	public function login(Application $app, Request $request)
	{
		$dataset = json_decode($request->getContent());
		$usuario = $dataset->usuario;
		$senha = $dataset->senha;
		$organizacao = $dataset->organizacao;

		$response = new Response();
		
		$sql = 'select * from usuario where usuario = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($usuario));

		if($resultado){
			if($resultado['senha'] != md5($senha)){
				$response->addMessage('error', "Senha invalida!");	
			} else {
				$app["session"]->set("usuario_logado", true);
            	$app["session"]->set("usuario", $usuario);
            	// $app["session"]->set("organizacao", $organizacao);

				$response->setData($resultado);
			}
		} else {
			$response->addMessage('error', "Usuario {$usuario}, não cadastrado!");
		}
		
		return $response->getAsJson();
	}

	public function logout(Application $app)
	{
		$response = new Response();

		$app['session']->invalidate();

		return array();
	}
}	