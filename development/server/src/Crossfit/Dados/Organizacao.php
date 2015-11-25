<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Organizacao
{
	public static function verificaOrganizacao($id_organizacao)
	{
		$sql = "SELECT * from organizacao where status = 'A' and id_organizacao = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_organizacao));

		return $resultado;
	}
}