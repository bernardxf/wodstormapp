<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\Dados\Aula;
use Crossfit\App;

class AlunoAula
{
	public static function retornaTodos()
	{
		$sql = 'select * from alunos_aula where id_organizacao = ?';
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaSelecionado($id_aula)
	{
		$organizacao = App::getSession()->get('organizacao');
		$sql = 'select aluno.id_aluno as id_aluno, aluno.nome as nome, alunos_aula.num_senha as senha from aluno
				join alunos_aula on alunos_aula.id_aluno = aluno.id_aluno
				where alunos_aula.id_aula = ? and alunos_aula.id_organizacao = ?
				order by alunos_aula.num_senha;';
		$resultado = Conexao::get()->fetchAll($sql, array($id_aula, $organizacao));

		return $resultado;
	}


	public static function retornaSelecionadoPorData($data)
	{
		$sql = 'select aula.id_aula as id_aula, aula.horario as horario, count(alunos_aula.id_aluno) as num_presentes, aula.excedente as num_excedentes from alunos_aula
				join aula on aula.id_aula = alunos_aula.id_aula
				where aula.data = ? and aula.id_organizacao = ?
				group by aula.id_aula';
		$resultado = Conexao::get()->fetchAll($sql, array($data, App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function salvaPresenca($presencaDataset)
	{
		$aulaDataset = array(
			'data' => $presencaDataset->data,
			'horario' => $presencaDataset->horario,
			// 'excedente' => $presencaDataset->excedente,
			'id_organizacao' => App::getSession()->get('organizacao')
		);

		Conexao::get()->insert('aula',$aulaDataset);

		$result = Conexao::get()->fetchAll('select max(id_aula) as id_aula from aula');

		$presentes = $presencaDataset->presentes;
		foreach ($presentes as $presente) {
			$alunosAulaDataset = array(
				'id_aluno' => $presente->id_aluno,
				'id_aula' => $result[0]['id_aula'],
				'num_senha' => $presente->senha,
				'id_organizacao' => App::getSession()->get('organizacao')
			);

			Conexao::get()->insert('alunos_aula', $alunosAulaDataset);
		}

		return true;
	}

	public static function atualizaPresenca($id_aula, $presencaDataset)
	{
		$aulaDataset = array(
			'data' => $presencaDataset->data,
			'horario' => $presencaDataset->horario,
			'excedente' => $presencaDataset->excedente,
			'id_organizacao' => App::getSession()->get('organizacao')
		);

		Conexao::get()->update('aula',$aulaDataset, array('id_aula' => $id_aula));		

		Conexao::get()->delete('alunos_aula', array('id_aula' => $id_aula, 'id_organizacao' => App::getSession()->get('organizacao')));

		$presentes = $presencaDataset->presentes;
		foreach ($presentes as $presente) {
			$alunosAulaDataset = array(
				'id_aluno' => $presente->id_aluno,
				'id_aula' => $id_aula,
				'num_senha' => $presente->senha,
				'id_organizacao' => App::getSession()->get('organizacao')
			);

			Conexao::get()->insert('alunos_aula', $alunosAulaDataset);
		}

		return true;
	}

	public static function removeAlunosAula($id_aula)
	{
		Conexao::get()->delete('aula', array('id_aula' => $id_aula, 'id_organizacao' => App::getSession()->get('organizacao')));

		return true;
	}
}