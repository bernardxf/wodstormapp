<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Configuracao;
use Crossfit\Util\Response;
use Crossfit\App;

class ConfiguracaoController
{
	public static function retornaConfiguracoesOrganizacao()
	{
		$id_organizacao = App::getSession()->get('organizacao');
		$response = new Response();
		$configuracoes = Configuracao::retornaConfiguracoesPorOrganizacao($id_organizacao);

		$response->setData($configuracoes);

		return $response->getAsJson();
	}

	public static function salvaConfiguracao(Request $request)
	{	
		$id_organizacao = App::getSession()->get('organizacao');
		$response = new Response();
		$dataset = json_decode($request->getContent(),true);	

		$resultado = Configuracao::atualizaConfiguracoes($dataset, $id_organizacao);	
		$response->setData($resultado);
	
		App::getSession()->set('configuracao', $dataset);

		return $response->getAsJson();
	}
}