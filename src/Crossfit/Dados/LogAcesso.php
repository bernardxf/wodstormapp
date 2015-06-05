<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class LogAcesso
{
	public static function salvaLogAcesso($dataset)
	{
		$resultado = Conexao::get()->insert('log_acesso', $dataset);

		return $resultado;
	}
}