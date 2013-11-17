<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Estacionamento
{
	public static function retornaTodos()
	{
		$sql = 'select * from estacionamento';
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}