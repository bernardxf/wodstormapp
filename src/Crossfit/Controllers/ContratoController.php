<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Contrato;
use Crossfit\Dados\Plano;
use Crossfit\Dados\FormaPagamento;
use Crossfit\Dados\Desconto;
use Crossfit\Util\Response;
use Crossfit\App;

class ContratoController
{
	public static function carregaContrato($id_aluno)
	{
		$response = new Response();

		$contrato = Contrato::retornaTodosPorAluno($id_aluno);
		$plano = Plano::retornaTodosSimples();
		$desconto = Desconto::retornaTodosSimples();
		$formaPagamento = FormaPagamento::retornaTodosSimples();

		$data = array("contrato" => $contrato, "selectPlano" => $plano, "selectDesconto" => $desconto, "selectFormaPagamento" => $formaPagamento);

		$response->setData($data);

		return $response->getAsJson();
	}

	public static function carregaCadContrato($id_aluno, $id_contrato)
	{
		$response = new Response();

		$contrato = Contrato::retornaSelecionado($id_contrato);
		$plano = Plano::retornaTodosSimples();
		$desconto = Desconto::retornaTodosSimples();
		$formaPagamento = FormaPagamento::retornaTodosSimples();

		$data = array("contrato" => $contrato, "selectPlano" => $plano, "selectDesconto" => $desconto, "selectFormaPagamento" => $formaPagamento);

		$response->setData($data);

		return $response->getAsJson();
	}

	public static function salvaContrato($id_aluno, Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(), true);
		$dataset['id_organizacao'] = App::getSession()->get('organizacao');

		$resultado = Contrato::salvaContrato($dataset);

		return $response->getAsJson();
	}

	public static function atualizaContrato($id_aluno, $id_contrato, Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(), true);

		$resultado = Contrato::atualizaContrato($id_contrato, $dataset);

		return $response->getAsJson();	
	}

	public static function removeContrato($id_aluno, $id_contrato)
	{
		$response = new Response();

		$resultado = Contrato::removeContrato($id_contrato);

		return $response->getAsJson();
	}
}