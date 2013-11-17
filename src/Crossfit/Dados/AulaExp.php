<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class AulaExp
{
	public static function retornaTodos()
	{
		$sql = 'select * from aulaexp';
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}