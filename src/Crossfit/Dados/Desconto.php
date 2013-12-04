<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Desconto
{
	public static function retornaTodos()
	{
		$sql = 'select * from desconto where id_organizacao = ?';
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaSelecionado($id_desconto)
	{	
		$sql = 'select * from desconto where id_desconto = ? and id_organizacao = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_desconto, App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function salvaDesconto($descontoDataset)
	{
		$resultado = Conexao::get()->insert('desconto', $descontoDataset);
		return $resultado;
	}

	public static function atualizaDesconto($descontoDataset, $id_desconto)
	{
		$resultado = Conexao::get()->update('desconto', $descontoDataset, array('id_desconto' => $id_desconto));
		return $resultado;
	}

	public static function removeDesconto($id_desconto)
	{
		$resultado = Conexao::get()->delete('desconto', array('id_desconto' => $id_desconto));
		return $resultado;
	}
}