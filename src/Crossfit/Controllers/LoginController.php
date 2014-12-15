<?php
namespace Crossfit\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Crossfit\Conexao;
use Crossfit\Util\Response;
use Crossfit\Dados\Usuario;
use Crossfit\Dados\Organizacao;

class LoginController
{
	public function login(Application $app, Request $request)
	{
		$dataset = json_decode($request->getContent());
		$usuario = $dataset->usuario;
		$senha = $dataset->senha;
		$organizacao = $dataset->organizacao;

		$response = new Response();
		
		$resultadoOrganizacao = Organizacao::verificaOrganizacao($organizacao);

		if($resultadoOrganizacao) {
			$usuario = Usuario::retornaUsuarioLogin($usuario, $senha, $organizacao);

			if($usuario){
				$app["session"]->set("usuario_logado", true);
				$app["session"]->set("usuario", $usuario);
				$app["session"]->set("organizacao", $organizacao);

				$response->setData($usuario);
			} else {
				$response->addMessage('danger', "Erro ao tentar logar!", "Dados incorretos ou usuário não cadastrado");	
				$response->setSuccess(false);
			}	
		} else {
			$response->addMessage('danger', "Erro ao tentar logar!", "Organização inexistente ou desativada.");	
			$response->setSuccess(false);
		}
		
		return $response->getAsJson();
	}

	public function logout(Application $app)
	{
		$response = new Response();

		$app['session']->invalidate();

		return $response->getAsJson();
	}
}	