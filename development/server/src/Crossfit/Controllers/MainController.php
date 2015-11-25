<?php 
namespace Crossfit\Controllers;

use Silex\Application;
use Crossfit\App;

class MainController
{
	public function startApp(Application $app)
	{
		return $app["twig"]->render("index.html");	
	}

	public function returnTemplate(Application $app, $template)
	{
		return $app["twig"]->render("partials/".$template.".html");
	}
}