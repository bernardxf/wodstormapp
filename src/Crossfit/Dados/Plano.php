<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Plano
{
	public static function retornaVencimentoPlanos()
	{
		$sql = "SELECT nome, DATE_FORMAT(plano_fim, '%d/%m/%Y') as plano_fim FROM aluno WHERE aluno_status = 'ativo' AND to_days(plano_fim) - to_days(SYSDATE()) <= 7 ORDER BY YEAR(plano_fim) ASC, MONTH(plano_fim) ASC, DAY(plano_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}