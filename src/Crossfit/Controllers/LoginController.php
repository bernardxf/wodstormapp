<?php
namespace Crossfit\Controllers;

use Silex\Application;
use Crossfit\Dados\Usuario;

class LoginController
{
	public function login(Application $app)
	{
		$resultado = Usuario::retornaTodos();
		return $app->json($resultado);
	}
}	