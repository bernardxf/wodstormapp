<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelAula
{
	public static function retornaSelecionado($horario, $data_ini, $data_fim)
	{
		$idOrganizacao = App::getSession()->get('organizacao');
		$sql = "SELECT count(*) as num_presentes, DATE_FORMAT(a.data, '%d/%m/%Y') as data, a.excedente FROM alunos_aula as aa
				JOIN aula a on aa.id_aula = a.id_aula and a.status = ?
				WHERE a.horario = ?
				AND a.data between ? and ?
				AND aa.id_organizacao = ?
				GROUP BY a.data";
				
		$resultado = Conexao::get()->fetchAll($sql, array('A', $horario, $data_ini, $data_fim, $idOrganizacao));

		return $resultado;

	}

}