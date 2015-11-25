<?php
namespace Crossfit;

use Silex\Application;

class App
{
	private static $app;

	public static function init(Application $app)
	{
		self::$app = $app;
	}

	public static function get()
	{
		return self::$app;
	}

	public static function getSession()
	{
		return self::$app['session'];
	}
}