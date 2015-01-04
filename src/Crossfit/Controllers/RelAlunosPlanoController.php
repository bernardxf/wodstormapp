<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\RelAlunosPlano;
use Crossfit\Util\Response;
use Crossfit\App;

class RelAlunosPlanoController
{
    public static function alunosPorPlano(Request $request)
    {
        $response = new Response();

        $resultado = RelAlunosPlano::retornaAlunosPorPlano();

        $response->setData($resultado);

        return $response->getAsJson();
    }
}