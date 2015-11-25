<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Configuracao
{
	public static function retornaConfiguracoesPorOrganizacao($id_organizacao)
	{
		$sql = "SELECT * from configuracao where id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array($id_organizacao));

		return $resultado[0];
	}

	public static function atualizaConfiguracoes($configuracaoDataset, $id_organizacao)
	{
		$resultado = Conexao::get()->update('configuracao', $configuracaoDataset, array('id_organizacao' => $id_organizacao));
		return $resultado;
	}
}