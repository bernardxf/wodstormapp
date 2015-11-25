<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class AgrupadorFinanceiro
{
	public static function retornaTodos()
	{
		$sql = "SELECT * from agrupador_financeiro where id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));

		return $resultado;
	}

	public static function salvaAgrupador($agrupadorDataset)
	{
		$resultado = Conexao::get()->insert('agrupador_financeiro', $agrupadorDataset);
		return $resultado;
	}
}