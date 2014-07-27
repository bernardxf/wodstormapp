<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Aluno
{
	public static function retornaTodos()
	{
//		$sql = "SELECT aluno.id_aluno, aluno.nome, aluno.email, aluno.tel_celular, (SELECT data_fim FROM contrato 
//					WHERE id_aluno = aluno.id_aluno
//					ORDER BY data_fim DESC 
//					limit 1) as data_fim 
//				FROM aluno 
//				WHERE aluno.status != ? AND id_organizacao = ?
//				ORDER BY aluno.nome";
        $sql = "SELECT aluno.id_aluno, aluno.nome, aluno.email, aluno.tel_celular, contrato.data_fim, contrato.status 
                FROM aluno
                JOIN contrato ON contrato.id_aluno = aluno.id_aluno  
                WHERE contrato.status != 'I' AND aluno.id_organizacao = 1
                ORDER BY aluno.nome";
		$resultado = Conexao::get()->fetchAll($sql, array('I', App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaTodosFiltradoPorNome($nome)
	{
		$sql = "SELECT a.id_aluno as id_aluno, a.nome as nome, a.observacao_presenca as observacao_presenca, plano.nome as plano, contrato.data_fim as data_fim,
				(
					SELECT count(1) from alunos_aula
					JOIN aula on aula.id_aula = alunos_aula.id_aula
					WHERE id_aluno = a.id_aluno
					AND DATE_FORMAT(aula.data,'%m/%Y') = DATE_FORMAT(sysdate(),'%m/%Y')
					AND alunos_aula.id_organizacao = 1
				) as total_aulas
				FROM aluno as a
				JOIN contrato on contrato.id_aluno = a.id_aluno
				JOIN plano on contrato.id_plano = plano.id_plano
				WHERE a.id_aluno NOT IN (
					SELECT id_aluno FROM alunos_aula 
					JOIN aula on aula.id_aula = alunos_aula.id_aula
					WHERE aula.data = CURDATE() and alunos_aula.id_organizacao = ?
				) AND a.nome LIKE ? AND a.status = ? AND contrato.status = ? AND a.id_organizacao = ?
				ORDER BY a.nome";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), '%'.$nome.'%', 'A', 'A',App::getSession()->get('organizacao')));
		return $resultado;	
	}

	public static function retornaSelecionado($id_aluno)
	{
		$sql = "select * from aluno where id_aluno = ? and id_organizacao = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_aluno, App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function salvaAluno($alunoDataset)
	{
		Conexao::get()->insert('aluno', $alunoDataset);

		$sql = "SELECT MAX(id_aluno) FROM aluno WHERE id_organizacao = ?";

		$id_aluno = Conexao::get()->fetchColumn($sql, array(App::getSession()->get('organizacao')));

		$alunoDataset['id_aluno'] = $id_aluno;

		return $alunoDataset;
	}

	public static function atualizaAluno($id_aluno, $alunoDataset)
	{
		$resultado = Conexao::get()->update('aluno', $alunoDataset, array('id_aluno' => $id_aluno));
		return $resultado;
	}

	public static function removeAluno($id_aluno)
	{
		$resultado = Conexao::get()->update('aluno', array('status' => 'I'), array('id_aluno' => $id_aluno));
		return $resultado;
	}

	public static function retornaTodosSimples()
	{
		$sql = "select id_aluno, nome from aluno where status = ? and id_organizacao = ? order by nome";
		$resultado = Conexao::get()->fetchAll($sql, array('A', App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaAniversariantes()
	{
		$sql = "SELECT aluno.nome, DATE_FORMAT(aluno.data_nasc, '%d/%m') data_nasc -- aluno.data_nasc
				FROM aluno AS aluno
				JOIN contrato AS contrato ON contrato.id_aluno = aluno.id_aluno
				WHERE aluno.status = ? 
				AND DATE_FORMAT(data_nasc, '%m') = DATE_FORMAT(SYSDATE(), '%m') 
				AND aluno.id_organizacao = ? 
				AND contrato.status = ?
				ORDER BY DAY(data_nasc) ASC";
		$resultado = Conexao::get()->fetchAll($sql, array('A', App::getSession()->get('organizacao'), 'A'));
		return $resultado;
	}

	public static function retornaTrancados()
	{
		$sql = "select nome, contrato.status FROM aluno 
				JOIN contrato on aluno.id_aluno = contrato.id_aluno
				WHERE contrato.status= ?
				AND contrato.id_organizacao = ? 
				AND aluno.status = ?
				ORDER BY nome ASC";
		$resultado = Conexao::get()->fetchAll($sql, array('T', App::getSession()->get('organizacao'), 'A'));
		return $resultado;
	}
}