<?php 
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Usuario
{
	public static function retornaTodos($organizacao = null)
	{
		$sql = "select id_usuario, nome, usuario, id_organizacao, id_grupo_usuario from usuario where status = 'A'";
		if ($organizacao) {
			$sql .= " and id_organizacao = '$organizacao'";
		}

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

	public static function salvaUsuario($usuarioDataset)
	{
		if (isset($usuarioDataset["senha"])) {
			$usuarioDataset["senha"] = md5($usuarioDataset["senha"]);
		}

		Conexao::get()->insert('usuario', $usuarioDataset);
		$sql = "SELECT MAX(id_usuario) FROM usuario WHERE id_organizacao = ?";
		$id_usuario = Conexao::get()->fetchColumn($sql, array(App::getSession()->get('organizacao')));
		$usuarioDataset['id_usuario'] = $id_usuario;
		return $usuarioDataset;
	}

	public static function removeUsuario($id_usuario)
	{
		$resultado = Conexao::get()->update('usuario', array('status' => 'I'), array('id_usuario' => $id_usuario));
		return $resultado;
	}

	public static function atualizaSenha($id_usuario, $novaSenha)
	{
		$resultado = Conexao::get()->update('usuario', array('senha' => md5($novaSenha)), array('id_usuario' => $id_usuario));
		return $resultado;
	}
}