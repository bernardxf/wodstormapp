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

	public static function retornaVencimentoEstacionamento()
	{
		$sql = "SELECT E.id_aluno_fk, DATE_FORMAT(E.plano_fim, '%d/%m/%Y') as plano_fim, A.nome FROM estacionamento AS E INNER JOIN aluno AS A ON (E.id_aluno_fk = A.id_aluno) WHERE estacionamento_status = 'trancado' OR to_days(E.plano_fim) - to_days(NOW()) <= 0 ORDER BY YEAR(E.plano_fim) ASC, MONTH(E.plano_fim) ASC, DAY(E.plano_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}