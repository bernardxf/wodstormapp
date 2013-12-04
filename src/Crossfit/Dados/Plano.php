<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Plano
{
	public static function retornaTodos()
	{
		$sql = "select * from plano where id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaSelecionado($id_plano)
	{
		$sql = "select * from plano where id_plano = ? and id_organizacao = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_plano, App::getSession()->get('organizacao')));
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
}