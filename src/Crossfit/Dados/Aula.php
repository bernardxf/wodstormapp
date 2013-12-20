<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Aula
{

	public static function retornaTodos()
	{
		$sql = 'select * from aula';
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaSelecionado($id_aula)
	{
		$sql = 'select * from aula where id_aula = ? and id_organizacao = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_aula, App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function salvaAula($aulaDataset)
	{
		$resultado = Conexao::get()->insert('aula', $aulaDataset);
		return $resultado;
	}

	public static function atualizaAula($id_aula, $aulaDataset)
	{
		$resultado = Conexao::get()->update('aula', $aulaDataset, array('id_aula' => $id_aula));
		return $resultado;
	}

	public static function removeAula($id_aula)
	{
		$resultado = Conexao::get()->delete('aula',array('id_aula' => $id_aula));
		return $resultado;
	}
}