<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelAluno
{
	public static function retornaSelecionado($id_aluno, $data_ini, $data_fim)
	{
		$sql = "SELECT a.nome, p.nome
				FROM aluno AS a, plano AS p
				JOIN contrato AS c ON c.id_plano = p.id_plano
				WHERE a.id_aluno = ? AND a.id_organizacao = ?
				ORDER BY p.nome DESC
				LIMIT 1";
		$aluno = Conexao::get()->fetchAll($sql, array($id_aluno, App::getSession()->get('organizacao')));

		$sql = "SELECT count(*) AS num_presencas FROM aluno AS a
				JOIN alunos_aula AS aa on a.id_aluno = aa.id_aluno
				JOIN aula AS au ON aa.id_aula = au.id_aula
				WHERE a.id_aluno = ? AND au.data BETWEEN '?' AND '?' AND a.id_organizacao = ?";
		$presencas = Conexao::get()->fetchAll($sql, array($id_aluno, $data_ini, $data_fim, App::getSession()->get('organizacao')));

		$sql = "SELECT au.data, au.horario FROM aula AS au
				JOIN alunos_aula AS aa ON aa.id_aula = au.id_aula
				JOIN aluno AS a ON aa.id_aluno = a.id_aluno
				WHERE a.id_aluno = ? AND au.data BETWEEN '?' AND '?' AND a.id_organizacao = ?";
		$dias = Conexao::get()->fetchAll($sql, array($id_aluno, $data_ini, $data_fim, App::getSession()->get('organizacao')));
		
		$resultado = array("aluno" => $aluno, "presencas" => $presencas, "dias" => $dias);

		return $resultado;

	}

}