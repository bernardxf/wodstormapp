<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Dashboard
{
	public static function retorna()
	{
		$sql = "SELECT (SELECT count(*) FROM contrato WHERE status = 'A' AND id_organizacao = ?) as ativo, (SELECT count(*) FROM contrato WHERE status = 'I' AND id_organizacao = ?) as inativo, (SELECT count(*) FROM contrato WHERE status = 'T' AND id_organizacao = ?) as trancado FROM contrato LIMIT 0,1";
		$resultado = Conexao::get()->fetchAssoc($sql, array(App::getSession()->get('organizacao'),App::getSession()->get('organizacao'),App::getSession()->get('organizacao')));
		return $resultado;
	}
}