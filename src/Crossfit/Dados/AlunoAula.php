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
		$sql = 'select aula.id_aula as id_aula, aula.horario as horario, count(alunos_aula.id_aluno) as num_presentes, aula.excedente as num_excedentes from aula
				left join alunos_aula on aula.id_aula = alunos_aula.id_aula 
				where aula.data = ? and aula.id_organizacao = ? and aula.status = ?
				group by aula.id_aula;';
		$resultado = Conexao::get()->fetchAll($sql, array($data, App::getSession()->get('organizacao'), 'A'));
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
		$aulaAtiva = Aula::retornaIdAulaAtiva();

		if($aulaAtiva == $id_aula) {
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
		return false;
	}

	public static function removeAlunosAula($id_aula)
	{
		Conexao::get()->update('aula', array('status' => 'I'), array('id_aula' => $id_aula, 'id_organizacao' => App::getSession()->get('organizacao')));

		return true;
	}

	public static function retornaPresencaAtiva()
	{
		$sql = "SELECT aluno.id_aluno as id_aluno, aluno.nome as nome, alunos_aula.num_senha as senha from aluno 
				join alunos_aula on alunos_aula.id_aluno = aluno.id_aluno 
				where alunos_aula.id_aula = ( 
					SELECT a.id_aula from aula a 
					where a.id_organizacao = ? and a.data = DATE_FORMAT(SYSDATE(), '%Y-%m-%d') 
					order by a.id_aula DESC 
					limit 1 ) 
				and alunos_aula.id_organizacao = ? order by alunos_aula.num_senha;";

		$presentes = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), App::getSession()->get('organizacao')));

		$sql = "SELECT a.id_aula from aula a 
				where a.id_organizacao = ? and a.data = DATE_FORMAT(SYSDATE(), '%Y-%m-%d') 
				order by a.id_aula DESC 
				limit 1";
		$aula = Conexao::get()->fetchAssoc($sql, array(App::getSession()->get('organizacao')));

		return array('aula' => (int) $aula['id_aula'], 'presentes' => $presentes);

	}

	public static function atualizaPresencaSalao($id_aula, $presente)
	{
		$sisConfig = App::getSession()->get('configuracoes');

		$sql = 'SELECT count(1) as numPresentes from alunos_aula where id_aula = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_aula));
		
		if((int)$resultado['numPresentes'] < (int)$sisConfig['maxPresentes']) {
			$alunosAulaDataset = array(
				'id_aluno' => $presente->id_aluno,
				'id_aula' => $id_aula,
				'num_senha' => $presente->senha,
				'id_organizacao' => App::getSession()->get('organizacao')
			);

			Conexao::get()->insert('alunos_aula', $alunosAulaDataset);	
			return true;
		}
		return false;
	}
}