<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Plano
{
	public static function retornaTodos()
	{
		$sql = "select * from plano";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaSelecionado($id_plano)
	{
		$sql = "select * from plano where id_plano = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_plano));
		return $resultado;
	}

	public static function salvaPlano($planoDataset)
	{
		$resultado = Conexao::get()->insert('plano', $planoDataset);
		return $resultado;
	}

	public static function atualizaPlano($planoDataset, $id_plano)
	{
		$resultado = Conexao::get()->update('plano', $planoDataset, array('id_plano' => $id_plano));
		return $resultado;
	}

	public static function removePlano($id_plano)
	{
		$resultado = Conexao::get()->delete('plano', array('id_plano' => $id_plano));
		return $resultado;
	}

	public static function retornaVencimentoPlanos()
	{
		$sql = "SELECT nome, DATE_FORMAT(plano_fim, '%d/%m/%Y') as plano_fim FROM aluno WHERE aluno_status = 'ativo' AND to_days(plano_fim) - to_days(SYSDATE()) <= 7 ORDER BY YEAR(plano_fim) ASC, MONTH(plano_fim) ASC, DAY(plano_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}