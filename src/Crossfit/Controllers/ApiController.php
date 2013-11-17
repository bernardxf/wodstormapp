<?php
namespace Crossfit\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class ApiController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$controllerCollection = new ControllerCollection(new \Silex\Route());
		
		$controllerCollection->get('/login', LoginController::login());

		return $controllerCollection;		
	}
}	