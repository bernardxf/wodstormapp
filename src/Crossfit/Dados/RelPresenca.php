<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelPresenca
{
	public static function retornaSelecionados($data_ini, $data_fim)
	{
        $sql = "select distinct(aluno.id_aluno) as id_aluno, aluno.nome as nome from aluno
                join contrato on contrato.id_aluno = aluno.id_aluno
                where aluno.id_aluno in (
                        select DISTINCT(id_aluno) from alunos_aula 
                        join aula on alunos_aula.id_aula = aula.id_aula
                        where alunos_aula.id_organizacao = ?
                        and aula.data between ? and ?
                )
                and aluno.id_organizacao = ? 
                and exists (
                    select id_contrato from contrato
                    where (data_inicio <= ? and data_fim >= ?)
                    and contrato.id_aluno = aluno.id_aluno
                )
                and exists (select id_contrato from contrato where status = 'A' and id_aluno = aluno.id_aluno)
                order by aluno.nome";

		$presentes = Conexao::get()->fetchAll($sql, array( App::getSession()->get('organizacao'), $data_ini, $data_fim, App::getSession()->get('organizacao'), $data_fim, $data_fim));

		$sql = "select distinct(aluno.id_aluno) as id_aluno, aluno.nome as nome from aluno
                join contrato on contrato.id_aluno = aluno.id_aluno
                where aluno.id_aluno not in (
                        select DISTINCT(id_aluno) from alunos_aula 
                        join aula on alunos_aula.id_aula = aula.id_aula
                        where alunos_aula.id_organizacao = ?
                        and aula.data between ? and ?
                )
                and aluno.id_organizacao = ? 
                and exists (
                    select id_contrato from contrato
                    where (data_inicio <= ? and data_fim >= ?)
                    and contrato.id_aluno = aluno.id_aluno
                )
                and exists (select id_contrato from contrato where status = 'A' and id_aluno = aluno.id_aluno)
                order by aluno.nome";

		$ausentes = Conexao::get()->fetchAll($sql, array( App::getSession()->get('organizacao'), $data_ini, $data_fim, App::getSession()->get('organizacao'), $data_fim, $data_fim));

		return array('presentes' => $presentes, 'ausentes' => $ausentes);
	}
}