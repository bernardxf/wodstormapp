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

	public static function atualizaUsuario($id_usuario, $usuarioDataset)
	{
		$resultado = Conexao::get()->update('usuario', $usuarioDataset, array('id_usuario' => $id_usuario));
		return $resultado;
	}

	public static function atualizaSenha($id_usuario, $novaSenha)
	{
		$resultado = Conexao::get()->update('usuario', array('senha' => md5($novaSenha)), array('id_usuario' => $id_usuario));
		return $resultado;
	}
}