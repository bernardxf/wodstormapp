<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Dashboard
{
	public static function retorna()
	{
		$sql = "select 
                (
                    select count(DISTINCT(contrato.id_aluno)) from contrato 
                    join aluno on aluno.id_aluno = contrato.id_aluno and aluno.status = 'A'
                    where contrato.id_organizacao = ? and contrato.status = 'A'
                ) as ativo,
                (
                    select count(DISTINCT(contrato.id_aluno)) from contrato 
                    join aluno on aluno.id_aluno = contrato.id_aluno and aluno.status = 'A'
                    where contrato.id_organizacao = ? and contrato.status = 'I'
                ) as inativo,
                (
                    select count(DISTINCT(contrato.id_aluno)) from contrato 
                    join aluno on aluno.id_aluno = contrato.id_aluno and aluno.status = 'A'
                    where contrato.id_organizacao = ? and contrato.status = 'T'
                ) as trancado,
                (
                    select count(distinct(c.id_aluno)) from contrato as c
                    join aluno on aluno.id_aluno = c.id_aluno and aluno.status = 'A'
                    where c.id_organizacao = ?
                    and c.status = 'F'
                    and not exists (
                        select 1 from contrato where status in ('A', 'I', 'T') and contrato.id_aluno = c.id_aluno
                    )
                ) as finalizado
                from dual;
                ";
		$resultado = Conexao::get()->fetchAssoc($sql, array(App::getSession()->get('organizacao'),App::getSession()->get('organizacao'),App::getSession()->get('organizacao'), App::getSession()->get('organizacao')));
		return $resultado;
	}

    public static function retornaAlunosPorTipo($tipo)
    {
        switch ($tipo) {
            case 'A':
            case 'I':
            case 'T':
                $sql = "select aluno.id_aluno as id_aluno, aluno.nome as nome from contrato 
                        join aluno on aluno.id_aluno = contrato.id_aluno and aluno.status = 'A'
                        where contrato.id_organizacao = ? and contrato.status = ?
                        order by aluno.nome";
                break;
            case 'F':
                $sql = "select aluno.id_aluno as id_aluno, aluno.nome from contrato as c
                        join aluno on aluno.id_aluno = c.id_aluno and aluno.status = 'A'
                        where c.id_organizacao = ?
                        and c.status = ?
                        and not exists (
                            select 1 from contrato where status in ('A', 'I', 'T') and contrato.id_aluno = c.id_aluno
                        )
                        order by aluno.nome";
                break;
        }

        $alunos = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), $tipo));
        return $alunos;
    }
}