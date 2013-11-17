<?php
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use JDesrosiers\Silex\Provider\CorsServiceProvider;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;

$loader = require 'vendor/autoload.php';
$loader->add('Crossfit', __DIR__ . '/src');
$config = parse_ini_file(__DIR__ . '/config/config.ini', true);

$app = new Application();

$app['routes'] = $app->extend('routes', function (RouteCollection $routes, Application $app) {
    $loader     = new YamlFileLoader(new FileLocator(__DIR__ . '/config'));
    $collection = $loader->load('routes.yml');
    $routes->addCollection($collection);
 
    return $routes;
});

$app->register(new CorsServiceProvider(), array(
    "cors.allowOrigin" => "http://localhost",
    "cors.allowMethods" => "GET,POST,PUT,DELETE"
));

$app->after($app["cors"]);

$app['debug'] = true;

$app->register(new DoctrineServiceProvider(), array(
        'dbs.options' => array(
            'main' => array(
                'driver' => $config['db']['driver'],
                'dbname' => $config['db']['dbname'],
                'host' => $config['db']['host'],
                'user' => $config['db']['user'],
                'password' => $config['db']['password'],
            )
        )
    )
);

\Crossfit\Conexao::init($app);