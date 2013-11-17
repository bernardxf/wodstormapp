<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Servicos
{
	public static function retornaTodos()
	{
		$sql = 'select * from servicos';
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}