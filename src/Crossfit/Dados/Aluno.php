<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Aluno
{
	public static function retornaTodos()
	{
		$sql = "select aluno.*, contrato.data_fim from aluno
				left join contrato on contrato.id_aluno = aluno.id_aluno
				where aluno.status = ?
				and (contrato.status = ? or contrato.status is null)
				and aluno.id_organizacao = ?;";
		$resultado = Conexao::get()->fetchAll($sql, array('A', 'A', App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaTodosFiltradoPorNome($nome)
	{
		$sql = "select aluno.id_aluno as id_aluno, aluno.nome as nome, plano.nome as plano, contrato.status as status, contrato.data_fim as data_fim from aluno 
				join contrato on contrato.id_aluno = aluno.id_aluno
				join plano on contrato.id_plano = plano.id_plano
				where aluno.id_aluno NOT IN (
					select id_aluno from alunos_aula 
					join aula on aula.id_aula = alunos_aula.id_aula
					where aula.data = CURDATE() and alunos_aula.id_organizacao = ?
				) and aluno.nome like ? AND aluno.status = ? AND contrato.status = 'A' AND aluno.id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), '%'.$nome.'%', 'A', App::getSession()->get('organizacao')));
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
		$sql = "select id_aluno, nome from aluno where id_organizacao = ? order by nome";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaAniversariantes()
	{
		$sql = "SELECT aluno.nome, aluno.data_nasc 
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