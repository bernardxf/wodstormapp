<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class AulaExp
{
	public static function retornaTodos()
	{
		$sql = "select * from aulaexp where id_organizacao = ?"; 
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaSelecionado($id_aulaexp)
	{
		$sql = "select * from aulaexp where id_aulaexp = ? and id_organizacao = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_aulaexp, App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function salvaAulaExp($aulaexpDataset)
	{
		$resultado = Conexao::get()->insert('aulaexp', $aulaexpDataset);
		return $resultado;
	}

	public static function atualizaAulaExp($aulaexpDataset, $id_aulaexp)
	{
		$resultado = Conexao::get()->update('aulaexp', $aulaexpDataset, array('id_aulaexp' => $id_aulaexp));
		return $resultado;
	}

	public static function removeAulaExp($id_aulaexp)
	{
		$resultado = Conexao::get()->delete('aulaexp', array('id_aulaexp' => $id_aulaexp));
		return $resultado;
	}
}