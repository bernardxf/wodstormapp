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
		$sql = "select id_aluno, nome from aluno";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}