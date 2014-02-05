<?php 
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Usuario
{
	public static function retornaTodos()
	{
		$sql = 'select * from usuario';
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaSelecionado($id_usuario)
	{	
		$sql = 'select * from usuario where id_usuario = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_usuario));
		return $resultado;
	}

	public static function retornaUsuarioLogin($usuario, $senha, $organizacao)
	{
		$sql = 'select * from usuario where usuario = ? and senha = ? and id_organizacao = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($usuario, md5($senha), $organizacao));
		return $resultado;
	}
}