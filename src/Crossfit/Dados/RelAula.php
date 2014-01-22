<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelAula
{
	public static function retornaSelecionado($horario, $data_ini, $data_fim)
	{
		$sql = "select count(*) as num_presentes, DATE_FORMAT(a.data, '%d/%m/%Y') as data, a.excedente from alunos_aula as aa
				join aula a on aa.id_aula = a.id_aula 
				where a.horario = ? 
				and a.data between ? and ?
				group by a.data";
				
		$resultado = Conexao::get()->fetchAll($sql, array($horario, $data_ini, $data_fim));

		return $resultado;

	}

}