<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class AlunoAula
{
	public static function retornaTodos()
	{
		$sql = 'select * from aluno_aula';
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}