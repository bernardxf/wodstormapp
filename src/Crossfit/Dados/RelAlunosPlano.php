<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelAlunosPlano
{
	public static function retornaAlunosPorPlano($horario, $data_ini, $data_fim)
	{
		$idOrganizacao = App::getSession()->get('organizacao');
		$sql = "select count(DISTINCT(contrato.id_aluno)) as num_alunos, plano.nome as plano, round(count(DISTINCT(contrato.id_aluno)) / (
					select count(DISTINCT(c.id_aluno)) from contrato as c
					join aluno  as a on a.id_aluno = c.id_aluno and a.status = 'A'
					where c.id_organizacao = ? and c.status in ('A', 'T')
				) * 100, 2) as percentual  from contrato 
				join aluno on aluno.id_aluno = contrato.id_aluno and aluno.status = 'A'
				join plano on plano.id_plano = contrato.id_plano
				where contrato.id_organizacao = ? and contrato.status in ('A','T')
				group by plano.id_plano
				order by plano.tipo ASC, plano.nome ASC;";
				
		$resultado = Conexao::get()->fetchAll($sql, array($idOrganizacao, $idOrganizacao));

		return $resultado;

	}

}