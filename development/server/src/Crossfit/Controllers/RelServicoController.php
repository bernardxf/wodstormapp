<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\RelServico;
use Crossfit\Util\Response;
use Crossfit\App;

class RelServicoController
{
    public static function pesquisaRelServico(Request $request)
    {
        $dadosPesquisa = json_decode($request->getContent());
        $response = new Response();

        $resultado = RelServico::retornaSelecionado($dadosPesquisa->tipo, $dadosPesquisa->data_ini, $dadosPesquisa->data_fim);

        $response->setData($resultado);

        return $response->getAsJson();
    }
}