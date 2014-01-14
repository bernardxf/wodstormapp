<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelServico
{
	public static function retornaSelecionado($tipo, $data_ini, $data_fim)
	{
		$sql = "SELECT data, SUM(valor) as valor FROM servico
				WHERE tipo = ?
				AND data between ? AND ?
				GROUP BY data";

		$resultado = Conexao::get()->fetchAll($sql, array($tipo, $data_ini, $data_fim));

		return $resultado;
	}
}