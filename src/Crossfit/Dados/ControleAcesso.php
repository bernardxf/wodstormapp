<?php 
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class ControleAcesso
{

	public static function getRegrasControleAcesso()
	{
		$sql = "select *
		          from controle_acesso
		          where id_organizacao = ?
		            and id_grupo_usuario = (
		            	select id_grupo_usuario
		            	  from usuario
		            	  where id_usuario     = ?
		            	    and id_organizacao = ?
		            )";

		$id_organizacao = App::getSession()->get("organizacao");
		$id_usuario     = App::getSession()->get("usuario")["id_usuario"];
die;
		$resultado = Conexao::get()->fetchAll($sql, array($id_organizacao, $id_grupoUsuario));
		return $resultado;
	}

}