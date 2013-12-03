<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Contrato
{
	public static function retornaVencimentoContrato()
	{
		$sql = "SELECT aluno.nome as nome, data_fim FROM contrato 
				JOIN aluno on contrato.id_aluno = aluno.id_aluno
				WHERE aluno_status = 'A' AND to_days(data_fim) - to_days(SYSDATE()) <= 7 
				ORDER BY YEAR(data_fim) ASC, MONTH(data_fim) ASC, DAY(data_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}