<?php
use Symfony\Component\HttpFoundation\Response;

require 'bootstrap.php';

$app->match('/', function() use ($app){
    return $app["twig"]->render("index.html");
});	
// $app->get('/', function(){
// 	$resposta = array('valor1' => 'teste1', 'valor2' => 'teste2');
//     return new Response(json_encode($resposta), 200, array('Access-Control-Allow-Origin' => '*', 'Content-Type' => 'application/json'));
// });

// $app->mount('/usuario', new Crossfit\Controllers\UsuarioController());
// $app->mount('/aluno', new Crossfit\Controllers\AlunoController());

// $app->mount('/api', new Crossfit\Controllers\ApiController());

//Controler para erros em requisições
// $app->error(function (\Exception $e, $code) {
//     switch ($code) {
//         case 404:
//             $message = 'The requested page could not be found.';
//             break;
//         default:
//             $message = 'We are sorry, but something went terribly wrong.';
//     }

//     return new Response($message);
// });

$app->run();