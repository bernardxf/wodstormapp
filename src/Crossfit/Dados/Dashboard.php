<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Dashboard
{
	public static function retorna()
	{
		$sql = "SELECT (SELECT count(*) FROM contrato WHERE status = 'A') as ativo, (SELECT count(*) FROM contrato WHERE status = 'I') as inativo, (SELECT count(*) FROM contrato WHERE status = 'T') as trancado FROM contrato LIMIT 0,1";
		$resultado = Conexao::get()->fetchAssoc($sql);
		return $resultado;
	}
}