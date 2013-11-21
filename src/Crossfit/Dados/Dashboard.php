<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Dashboard
{
	public static function retorna()
	{
		$sql = "SELECT (SELECT count(*) FROM aluno WHERE aluno_status = 'ativo') as ativo, (SELECT count(*) FROM aluno WHERE id_desconto_fk = 14) as bolsa50, (SELECT count(*) FROM aluno WHERE id_desconto_fk = 15) as bolsa100, (SELECT count(*) FROM aluno WHERE aluno_status = 'inativo') as inativo, (SELECT count(*) FROM aluno WHERE aluno_status = 'trancado') as trancado FROM aluno LIMIT 0,1";
		$resultado = Conexao::get()->fetchAssoc($sql);
		return $resultado;
	}
}