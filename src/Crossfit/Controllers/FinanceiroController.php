<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Financeiro;
use Crossfit\Util\Response;
use Crossfit\App;

class FinanceiroController
{
    public static function carregaFinanceiro(Request $request)
    {
    	$response = new Response();
    	$ano = $request->query->get('ano');
    	$mes = $request->query->get('mes');

    	$categorias = Financeiro::buscaCategorias();
    	$anos = Financeiro::buscaAnosExistentes();

    	if($ano && $mes) {
    		$dadosFinanceiro = Financeiro::retornaTodosPorAnoMes($ano, $mes);
    	} else if($ano) {
    		$dadosFinanceiro = Financeiro::retornaTodosPorAno($ano);
    	} else {
    		$dadosFinanceiro = Financeiro::retornaTodos();	
    	}

    	$response->setData(array('dadosFinanceiro' => $dadosFinanceiro, 'categorias' => $categorias, 'anos' => $anos));

    	return $response->getAsJson();
    }

	public static function carregaCadFinMovimento($id_financeiro)
	{
		$response = new Response();
		$dadosFinanceiro = Financeiro::retornaSelecionado($id_financeiro);
		$categorias = Financeiro::buscaCategorias();

		$response->setData(array('dadosFinanceiro' => $dadosFinanceiro, 'categorias' => $categorias));

		return $response->getAsJson();
	}

	public static function salvaFinMovimento(Request $request)
	{
		$response = new Response();
		$movimentoDataset = json_decode($request->getContent(), true);

		$movimentoDataset['id_organizacao'] = App::getSession()->get('organizacao');

		Financeiro::salvaMovimento($movimentoDataset);

		return $response->getAsJson();
	}

	public static function atualizaFinMovimento($id_financeiro, Request $request)
	{
		$response = new Response();
		$movimentoDataset = json_decode($request->getContent(), true);
	
		Financeiro::atualizaMovimento($movimentoDataset, $id_financeiro);

		return $response->getAsJson();
	}

	public static function removeFinMovimento($id_financeiro)
	{
		$response = new Response();

		Financeiro::removeMovimento($id_financeiro);

		return $response->getAsJson();
	}
}