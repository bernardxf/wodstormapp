<?php
namespace Crossfit\Controllers;

use Crossfit\Dados\ControleAcesso;
use Crossfit\Util\Response;

class ControleAcessoController
{

	public static function getRegras() 
	{
		$response = new Response();
		// $usuario = App::getSession()->get('usuario');
		$response->setData(\Crossfit\Dados\ControleAcesso::getRegras());
		return $response->getAsJson();
	}
}