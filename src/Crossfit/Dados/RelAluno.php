<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelAluno
{
	public static function retornaSelecionado($id_aluno, $data_ini, $data_fim)
	{
		$sql = "select aluno.nome as aluno, plano.nome as plano, contrato.data_inicio, contrato.data_fim, count(*) as num_presencas from aluno
				join contrato on aluno.id_aluno = contrato.id_aluno
				join plano on contrato.id_plano = plano.id_plano
				join alunos_aula on aluno.id_aluno = alunos_aula.id_aluno
				join aula on alunos_aula.id_aula = aula.id_aula
				where aula.data between ? and ?
				and aula.data between contrato.data_inicio and contrato.data_fim
				and aluno.id_aluno = ?
				group by contrato.id_contrato";

		$aluno = Conexao::get()->fetchAll($sql, array($data_ini, $data_fim, $id_aluno));

		$sql = "select aula.data as data, aula.horario as horario from aula 
				join alunos_aula on aula.id_aula = alunos_aula.id_aula
				where aula.data between ? and ? and alunos_aula.id_aluno = ? and aula.id_organizacao = ?";

		$aulas = Conexao::get()->fetchAll($sql, array($data_ini, $data_fim, $id_aluno, App::getSession()->get('organizacao')));

		return array('aluno' => $aluno, 'aulas' => $aulas);

	}

	public static function relatorioAlunoBairro($colunaRelatorio)
	{
		$sql = "select count(DISTINCT(contrato.id_aluno)) as num_alunos, if(isnull(nullif(aluno.bairro, '')), 'Não informado', aluno.bairro) as bairro, round(count(DISTINCT(contrato.id_aluno)) / (
					select count(DISTINCT(c.id_aluno)) from contrato as c
					join aluno  as a on a.id_aluno = c.id_aluno and a.status = 'A'
					where c.id_organizacao = ? and c.status in ('A', 'T')
				) * 100, 2) as percentual  from contrato 
				join aluno on aluno.id_aluno = contrato.id_aluno and aluno.status = 'A'
				join plano on plano.id_plano = contrato.id_plano
				where contrato.id_organizacao = ? and contrato.status in ('A','T')
				group by aluno.bairro
				order by aluno.bairro ASC;";

		$resultadoFiltro = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), App::getSession()->get('organizacao')));

		return $resultadoFiltro;
	}

}