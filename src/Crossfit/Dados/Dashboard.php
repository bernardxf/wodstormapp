<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Dashboard
{
	public static function retorna()
	{
		$sql = "SELECT (SELECT count(*) FROM aluno WHERE aluno_status = 'A') as ativo, (SELECT count(*) FROM aluno WHERE aluno_status = 'I') as inativo, (SELECT count(*) FROM aluno WHERE aluno_status = 'T') as trancado FROM aluno LIMIT 0,1";
		$resultado = Conexao::get()->fetchAssoc($sql);
		return $resultado;
	}
}