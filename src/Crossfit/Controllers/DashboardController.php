<?php
namespace Crossfit\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Crossfit\Dados\Dashboard;
use Crossfit\Dados\Aluno;
use Crossfit\Dados\Contrato;
use Crossfit\Dados\Estacionamento;
use Crossfit\Util\Response;

class DashboardController
{
	public static function carregaDashboard()
	{
		$response = new Response();

		$dashboard = Dashboard::retorna();
		$aniversarios = Aluno::retornaAniversariantes();
		$plano = Contrato::retornaVencimentoContrato();
		$estacionamentoVencido = Estacionamento::retornaEstacionamentoVencido();
		$estacionamentoTrancado = Estacionamento::retornaEstacionamentoTrancado();
		$response->setData(array(
			'dashboard' => $dashboard, 
			'aniversarios' => $aniversarios, 
			'plano' => $plano, 
			'estacionamentoVencido' => $estacionamentoVencido, 
			'estacionamentoTrancado' => $estacionamentoTrancado
		));

		return $response->getAsJson();
	}

	public static function carregaRelatorioAniversariantes() 
	{
		$response = new Response();

		$data = new \DateTime();
		$aniversariantes = Aluno::retornaAniversariantes();

		// Tradução dos nomes dos meses para português.
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
		date_default_timezone_set('America/Sao_Paulo');
		$date = $data->format("Y-m-d");
		$date = strftime("Aniversariantes de %B", strtotime( $date ));

		$relatorio = array (
			"titulo"           => $date,
			"logo_wodstormapp" => "public/assets/img/logos/logo-login.png",
			"nome"             => "",
			"versao"           => "",
			"dataCriacao"      => "",
			"colunas"          => array(
				"nome"      => "Nome",
				"data_nasc" => "Data"
			),
			"dados"            => $aniversariantes,
		);

		$response->setData(array("relatorio" => $relatorio));
		return $response->getAsJson();
	}

	public static function carregaAlunosDashboard(Request $request) 
	{
		$response = new Response();
		$tipo = $request->query->get('tipo');

		$alunos = Dashboard::retornaAlunosPorTipo($tipo);
		$response->setData(array('alunos' => $alunos));

		return $response->getAsJson();
	}

}