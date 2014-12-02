<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Contrato;
use Crossfit\Dados\HistoricoContrato;
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

		if ($resultado) {
			// Se o novo contrato for salvo com sucesso, todos os contratos anteriores deste aluno deverão ser
			// colocados como encerrados, com data de fim para a data inicial do novo contrato criado.
			Contrato::finalizaContratosAnteriores($resultado);

			// Cadastrando o contrato salvo no historico.
			$historicoDataset = array(
				'id_contrato' => $resultado['id_contrato'],
				'id_aluno' => $resultado['id_aluno'],
				'data' => $resultado['data_inicio'],
				'status_contrato' => $resultado['status'],
				'id_organizacao' => App::getSession()->get('organizacao')
			);	

			HistoricoContrato::salvar($historicoDataset);
		}

		return $response->getAsJson();
	}

	public static function atualizaContrato($id_aluno, $id_contrato, Request $request)
	{
		$response = new Response();
		$dataset = json_decode($request->getContent(), true);

		$contratoAtual = Contrato::retornaSelecionado($id_contrato);

		// Caso o status do contrato esteja sendo alterado de 'A' (Ativo) para 'F' (Finalizado)
		// e sua data_fim seja maior que a data da alteração do estado a data_fim
		// passa a ser a data da alteração
		if($contratoAtual['status'] == 'A' && $dataset['status'] == 'F') {
			if(date('Y-m-d') < $dataset['data_fim']) $dataset['data_fim'] = date('Y-m-d');	
		}

		if($contratoAtual['status'] != $dataset['status']) {
			$historicoDataset = array(
				'id_contrato' => $dataset['id_contrato'],
				'id_aluno' => $dataset['id_aluno'],
				'data' => date('Y-m-d'),
				'status_contrato' => $dataset['status'],
				'id_organizacao' => App::getSession()->get('organizacao')
			);	

			HistoricoContrato::salvar($historicoDataset);
		}

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