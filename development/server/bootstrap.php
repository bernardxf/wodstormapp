<?php
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
// use JDesrosiers\Silex\Provider\CorsServiceProvider;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


use Crossfit\Util\Response as UtilResponse;

date_default_timezone_set('America/Sao_Paulo');    

$loader = require 'vendor/autoload.php';
$loader->add('Crossfit', __DIR__ . '/src');
$config = parse_ini_file(__DIR__ . '/config/config.ini', true);

$app = new Application();
$app['debug'] = true;


$app->before(function(Request $request) use($app){
    $arrRotasLiberadas = array('app', 'login', 'logado', 'buscarLeaderboard');

    if(!in_array($request->get('_route'), $arrRotasLiberadas) && !$app['session']->get('usuario_logado')) {
        $response = new UtilResponse();
        $response->addMessage('danger', 'Erro', 'Erro ao tentar acessar recurso!');
        $response->setSuccess(false);
        return $response->getAsJson();
    }
});

$app['routes'] = $app->extend('routes', function (RouteCollection $routes, Application $app) {
    $loader     = new YamlFileLoader(new FileLocator(__DIR__ . '/config'));
    $collection = $loader->load('routes.yml');
    $routes->addCollection($collection);
 
    return $routes;
});

$app->register(new Silex\Provider\SessionServiceProvider());
$app['session']->start();

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../www'
));
$app->register(new UrlGeneratorServiceProvider());
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


// Caso de erro 404 na rota, ele envia para a tela de barra
$app->error(function (\Exception $e, $code) use($app){
    if($code == 404) {
        $subRequest = Request::create('/', 'GET');
        return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
    }
});

\Crossfit\Conexao::init($app);
\Crossfit\App::init($app);