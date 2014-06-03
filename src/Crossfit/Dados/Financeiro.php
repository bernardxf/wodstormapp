<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Financeiro
{
	public static function retornaTodos()
	{
		$sql = "SELECT * from financeiro WHERE id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));

		return $resultado;
	}

	public static function retornaTodosPorAno($ano)
	{
		$sql = "SELECT * from financeiro WHERE DATE_FORMAT(data, '%Y') = ? AND id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array($ano, App::getSession()->get('organizacao')));

		return $resultado;
	}

	public static function retornaTodosPorAnoMes($ano, $mes)
	{
		$sql = "SELECT * from financeiro WHERE DATE_FORMAT(data, '%Y-%c') = ? AND id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array($ano.'-'.$mes, App::getSession()->get('organizacao')));

		return $resultado;
	}

	public static function retornaSelecionado($id_financeiro)
	{
		$sql = "SELECT * from financeiro WHERE id_financeiro = ? AND id_organizacao = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_financeiro, App::getSession()->get('organizacao')));

		return $resultado;
	}

	public static function salvaMovimento($movimentoDataset)
	{
		$resultado = Conexao::get()->insert('financeiro', $movimentoDataset);
		return $resultado;
	}

	public static function atualizaMovimento($movimentoDataset, $id_financeiro)
	{
		$resultado = Conexao::get()->update('financeiro', $movimentoDataset,array('id_financeiro' => $id_financeiro));
		return $resultado;
	}

	public static function removeMovimento($id_financeiro)
	{
		$resultado = Conexao::get()->delete('financeiro', array('id_financeiro' => $id_financeiro));
		return $resultado;
	}

	public static function buscaCategorias()
	{
		$sql = "SELECT id_agrupador, nome from agrupador_financeiro where id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function buscaAnosExistentes()
	{
		$sql = "SELECT DATE_FORMAT(data, '%Y') as ano from financeiro where id_organizacao = ? group by (1)";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;	
	}
}