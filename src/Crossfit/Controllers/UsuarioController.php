<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Usuario;
use Crossfit\Util\Response;
use Crossfit\App;

class UsuarioController
{
	public function retornaUsuarioLogado()
	{
		$response = new Response();

		$usuario = App::getSession()->get('usuario');
		$response->setData($usuario);

		return $response->getAsJson();
	}

	public function salvaUsuario(request $request)
	{

	}
}