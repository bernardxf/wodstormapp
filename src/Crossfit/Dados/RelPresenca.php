<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelPresenca
{
	public static function retornaSelecionados($data_ini, $data_fim)
	{
//        $sql = "select 
//                    (select count(1) from aluno where id_aluno in (
//                        select alunos_aula.id_aluno from alunos_aula
//                        join aula on aula.id_aula = alunos_aula.id_aula
//                        join contrato on contrato.id_aluno = alunos_aula.id_aluno
//                        where aula.id_organizacao = ?
//                        and aula.data between ? and ?
//                        and contrato.status = 'A'
//                        group by alunos_aula.id_aluno
//                    )) as presentes, 
//                    (select count(1) from aluno 
//                    join contrato on contrato.id_aluno = aluno.id_aluno
//                    where aluno.id_aluno not in (
//                        select alunos_aula.id_aluno from alunos_aula
//                        join aula on aula.id_aula = alunos_aula.id_aula
//                        join contrato on contrato.id_aluno = alunos_aula.id_aluno
//                        where aula.id_organizacao = ?
//                        and aula.data between ? and ?
//                        and contrato.status = 'A'
//                        group by alunos_aula.id_aluno
//                    ) and contrato.status = 'A' and aluno.id_organizacao = ?) as ausentes 
//                from dual";
//        $resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), $data_ini, $data_fim, App::getSession()->get('organizacao'), $data_ini, $data_fim, App::getSession()->get('organizacao')));
//		return $resultado;
        $sql = "select id_aluno, nome, count(1) from aluno where id_aluno in (
                select alunos_aula.id_aluno from alunos_aula
                join aula on aula.id_aula = alunos_aula.id_aula
                join contrato on contrato.id_aluno = alunos_aula.id_aluno
                where aula.id_organizacao = ?
                and aula.data between ? and ?
                and contrato.status = 'A'
                group by alunos_aula.id_aluno";

		$presentes = Conexao::get()->fetchAll($sql, array( App::getSession()->get('organizacao'), $data_ini, $data_fim));

		$sql = "select id_aluno, nome, count(1) from aluno 
                join contrato on contrato.id_aluno = aluno.id_aluno
                where aluno.id_aluno not in (
                select alunos_aula.id_aluno from alunos_aula
                join aula on aula.id_aula = alunos_aula.id_aula
                join contrato on contrato.id_aluno = alunos_aula.id_aluno
                where aula.id_organizacao = ?
                and aula.data between ? and ?
                and contrato.status = 'A'
                group by alunos_aula.id_aluno
                ) and contrato.status = 'A' and aluno.id_organizacao = ?";

		$ausentes = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), $data_ini, $data_fim, App::getSession()->get('organizacao')));

		return array('presentes' => $presentes, 'ausentes' => $ausentes);
	}
}