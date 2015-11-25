<?php
namespace Crossfit;

use Crossfit\Conexao;

class Login
{
	private static $errors = array();

	public static function login($usuario, $senha)
	{
		$db = Conexao::get();
		$sql = 'select * from usuario where usuario = ?';
		$usuario = $db->fetchAssoc($sql, array($usuario));

		if($usuario){
			if($usuario['ativo'] === 'N'){
				self::$errors[] = 'Usuário Inativo';
				return false;
			}

			if($usuario['senha'] === md5($senha)){
				return $usuario;	
			}

			self::$errors[] = 'Senha Invalida';
		} else {
			self::$errors[] = 'Usuário não existe';
		}

		return false;
	}

	public static function getErrors()
	{
		return implode(', ', self::$errors);
	}
}