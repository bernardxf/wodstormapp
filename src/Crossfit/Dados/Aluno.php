<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Aluno
{
	public static function retornaTodos()
	{
		$sql = 'select * from aluno where id_organizacao = ?';
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaTodosFiltradoPorNome($nome)
	{
		$sql = "select aluno.id_aluno as id_aluno, aluno.nome as nome, plano.nome as plano, contrato.status as status, contrato.data_fim as data_fim from aluno 
				join contrato on contrato.id_aluno = aluno.id_aluno
				join plano on contrato.id_plano = plano.id_plano
				where aluno.nome like ? and aluno.id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array($nome.'%', 1));
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
		$resultado = Conexao::get()->insert('aluno', $alunoDataset);
		return $resultado;
	}

	public static function atualizaAluno($id_aluno, $alunoDataset)
	{
		$resultado = Conexao::get()->update('aluno', $alunoDataset, array('id_aluno' => $id_aluno));
		return $resultado;
	}

	public static function removeAluno($id_aluno)
	{
		$resultado = Conexao::get()->delete('aluno', array('id_aluno' => $id_aluno));
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
		$sql = "select nome, data_nasc FROM aluno WHERE DATE_FORMAT(data_nasc, '%m') = DATE_FORMAT(SYSDATE(), '%m') ORDER BY data_nasc";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaTrancados()
	{
		$sql = "select nome, contrato.status FROM aluno 
				JOIN contrato on aluno.id_aluno = contrato.id_aluno
				WHERE contrato.status= 'T' ORDER BY nome ASC";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}