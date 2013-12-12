<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class RelAluno
{
	public static function retornaSelecionado($id_aluno, $data_ini, $data_fim)
	{
		$sql = "select aluno.nome as aluno, plano.nome as plano, count(*) as num_presencas from aluno
				join contrato on aluno.id_aluno = contrato.id_aluno
				join plano on contrato.id_plano = plano.id_plano
				join alunos_aula on aluno.id_aluno = alunos_aula.id_aluno
				join aula on alunos_aula.id_aula = aula.id_aula
				where aula.data between ? and ?
				and aluno.id_aluno = ?";

		$resultado = Conexao::get()->fetchAssoc($sql, array($data_ini, $data_fim, $id_aluno));

		return $resultado;

	}

}