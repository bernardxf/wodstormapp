<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Estacionamento
{
	public static function retornaTodos()
	{
		$sql = 'select estacionamento.*, aluno.nome as aluno from estacionamento join aluno on estacionamento.id_aluno = aluno.id_aluno where estacionamento.id_organizacao = ?';
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaSelecionado($id_estacionamento)
	{
		$sql = 'select * from estacionamento where id_estacionamento = ? and id_organizacao = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_estacionamento, App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function salvaEstacionamento($estacionamentoDataset)
	{
		$resultado = Conexao::get()->insert('estacionamento', $estacionamentoDataset);
		return $ressultado;
	}

	public static function atualizaEstacionamento($estacionamentoDataset, $id_estacionamento)
	{
		$resultado = Conexao::get()->update('estacionamento', $estacionamentoDataset, array('id_estacionamento' => $id_estacionamento));
		return $ressultado;
	}

	public static function removeEstacionamento($id_estacionamento)
	{
		$resultado = Conexao::get()->delete('estacionamento', array('id_estacionamento' => $id_estacionamento));
		return $resultado;
	}

	public static function retornaEstacionamentoVencido()
	{
		$sql = "SELECT a.nome, plano_fim from estacionamento as e
				JOIN aluno AS a ON e.id_aluno = a.id_aluno
				WHERE to_days(e.plano_fim) - to_days(NOW()) <= 0 
				AND e.id_organizacao = ?
				AND e.estacionamento_status = ?
				ORDER BY YEAR(e.plano_fim) ASC, MONTH(e.plano_fim) ASC, DAY(e.plano_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), 'A'));
		return $resultado;
	}

	public static function retornaEstacionamentoTrancado()
	{
		$sql = "SELECT aluno.nome, estacionamento.placa from estacionamento
				JOIN aluno ON estacionamento.id_aluno = aluno.id_aluno
				WHERE estacionamento_status = ?
				AND estacionamento.id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array('T',App::getSession()->get('organizacao')));
		return $resultado;
	}
}