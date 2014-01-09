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

		$response->setData(array('dashboard' => $dashboard, 'aniversarios' => $aniversarios, 'plano' => $plano, 'trancado' => $trancado, 'estacionamentoVencido' => $estacionamentoVencido, 'estacionamentoTrancado' => $estacionamentoTrancado));

		return $response->getAsJson();
	}
}