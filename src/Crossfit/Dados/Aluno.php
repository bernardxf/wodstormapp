<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Aluno
{
	public static function retornaTodos()
	{
		$sql = 'select * from aluno';
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaSelecionado($id_aluno)
	{
		$sql = "select * from aluno where id_aluno = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_aluno));
		return $resultado;
	}

	public static function retornaTodosSimples()
	{
		$sql = "select id_aluno, nome from aluno order by nome";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaAniversariantes()
	{
		$sql = "SELECT nome, data_nasc FROM aluno WHERE DATE_FORMAT(data_nasc, '%m') = DATE_FORMAT(SYSDATE(), '%m') ORDER BY data_nasc";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaTrancados()
	{
		$sql = "SELECT nome, aluno_status FROM aluno WHERE aluno_status = 'T' ORDER BY nome ASC";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}