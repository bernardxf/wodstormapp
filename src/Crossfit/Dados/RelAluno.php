<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelAluno
{
	public static function retornaSelecionado($id_aluno, $data_ini, $data_fim)
	{
		$sql = "SELECT a.nome as aluno , p.nome as plano FROM aluno as a 
				join plano as p on a.id_plano_fk = p.id_plano
				WHERE a.id_aluno = ?";
		$aluno = Conexao::get()->fetchAll($sql, $id_aluno);

		$sql = "SELECT count(*) as num_presencas FROM aluno as a
				join alunos_aula as aa on a.id_aluno = aa.id_aluno_fk
				join aula as au on aa.id_aula_fk = au.id_aula
				WHERE a.id_aluno = ? AND au.data BETWEEN '?' AND '?'";
		$presencas = Conexao::get()->fetchAll($sql, array($id_aluno, $data_ini, $data_fim));
		
		$resultado = array("aluno" => $aluno, "presencas" => $presencas);

		return $resultado;

	}

}