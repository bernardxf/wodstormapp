<?php 
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class ControleAcesso
{

	public static function getRegras()
	{
		// $sql = "select *
		//           from controle_acesso
		//           where id_organizacao = ?
		//             and id_grupo_usuario = (
		//             	select id_grupo_usuario
		//             	  from usuario
		//             	  where id_usuario     = ?
		//             	    and id_organizacao = ?
		//             )";
		$sql = "select pa.*, ca.componente
						  from permissao_acesso pa
						  inner join controle_acesso ca
						    on ca.id_controle_acesso = pa.id_controle_acesso 
						  where pa.id_organizacao = ?
						    and pa.id_grupo_usuario = (
							  select id_grupo_usuario
						        from usuario
						        where id_usuario     = ?
						          and id_organizacao = ?
							)";

		$id_organizacao = App::getSession()->get("organizacao");
		$usuario = App::getSession()->get("usuario");
		$id_usuario = $usuario["id_usuario"];

		$resultado = Conexao::get()->fetchAll($sql, array($id_organizacao, $id_usuario, $id_organizacao));
		return $resultado;
	}

}