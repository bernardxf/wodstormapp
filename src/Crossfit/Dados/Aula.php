<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Aula
{
	public static function retornaTodos()
	{
		$sql = 'select * from aula';
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaSelecionado($id_aula)
	{
		$sql = 'select * from aula where id_aula = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_aula));
		return $resultado;
	}
}