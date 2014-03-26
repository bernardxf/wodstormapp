<?php
namespace Crossfit\Controllers;

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
		$trancado = Aluno::retornaTrancados();
		$estacionamentoVencido = Estacionamento::retornaEstacionamentoVencido();
		$estacionamentoTrancado = Estacionamento::retornaEstacionamentoTrancado();
		$response->setData(array(
			'dashboard' => $dashboard, 
			'aniversarios' => $aniversarios, 
			'plano' => $plano, 
			'trancado' => $trancado, 
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
		$relatorio = array (
			"titulo"           => "aniversariantes do Mês de {$data->format('F')} de {$data->format('Y')}",
			"logo_cliente"     => "public/assets/img/logos/logo-login.png",
			"logo_wodstormapp" => "http://cdn.wordimpress.com/assets/icon-grunt.png",
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

}