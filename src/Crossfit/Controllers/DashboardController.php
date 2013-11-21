<?php
namespace Crossfit\Controllers;

use Crossfit\Dados\Dashboard;
use Crossfit\Dados\Aluno;
use Crossfit\Dados\Plano;
use Crossfit\Dados\Estacionamento;
use Crossfit\Util\Response;

class DashboardController
{
	public static function carregaDashboard()
	{
		$response = new Response();

		$dashboard = Dashboard::retorna();
		$aniversarios = Aluno::retornaAniversariantes();
		$plano = Plano::retornaVencimentoPlanos();
		$trancado = Aluno::retornaTrancados();
		$estacionamento = Estacionamento::retornaVencimentoEstacionamento();

		$response->setData(array('dashboard' => $dashboard, 'aniversarios' => $aniversarios, 'plano' => $plano, 'trancado' => $trancado, 'estacionamento' => $estacionamento));

		return $response->getAsJson();
	}
}