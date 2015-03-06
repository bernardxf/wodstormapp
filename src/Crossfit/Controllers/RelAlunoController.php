<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Aluno;
use Crossfit\Dados\RelAluno;
use Crossfit\Util\Response;
use Crossfit\App;

class RelAlunoController
{
    public static function carregaRelAluno(Request $request)
    {
        $filtro = $request->query->get('filtro');

        if($filtro) {
            return self::relatorioCustomizavel($request, $filtro);
        } else {
            $response = new Response();

            $resultado = Aluno::retornaTodosSimples();

            $response->setData($resultado);

            return $response->getAsJson();    
        }
    }

    public static function pesquisaRelAluno(Request $request)
    {
        $dadosPesquisa = json_decode($request->getContent());
        $response = new Response();

        $resultado = RelAluno::retornaSelecionado($dadosPesquisa->id_aluno, $dadosPesquisa->data_ini, $dadosPesquisa->data_fim);

        $response->setData($resultado);

        return $response->getAsJson();
    }

    public static function relatorioCustomizavel(Request $request, $filtro)
    {
        switch ($filtro){
            case 'bairro':
                return self::relatorioAlunoBairro($request);
                break;
        }
    }

    public static function relatorioAlunoBairro(Request $request)
    {
        $response = new Response();

        $resultado = RelAluno::relatorioAlunoBairro();

        $response->setData($resultado);

        return $response->getAsJson();

    }
}