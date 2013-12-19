<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\RelAula;
use Crossfit\Util\Response;
use Crossfit\App;

class RelAulaController
{
    public static function pesquisaRelAula(Request $request)
    {
        $dadosPesquisa = json_decode($request->getContent());
        $response = new Response();

        $resultado = RelAula::retornaSelecionado($dadosPesquisa->horario, $dadosPesquisa->data_ini, $dadosPesquisa->data_fim);

        $response->setData($resultado);

        return $response->getAsJson();
    }
}