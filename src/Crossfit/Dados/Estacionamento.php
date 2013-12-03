<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class Estacionamento
{
	public static function retornaTodos()
	{
		$sql = 'select estacionamento.*, aluno.nome as aluno from estacionamento join aluno on estacionamento.id_aluno_fk = aluno.id_aluno';
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaSelecionado($id_estacionamento)
	{
		$sql = 'select * from estacionamento where id_estacionamento = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_estacionamento));
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

	public static function retornaVencimentoEstacionamento()
	{
		$sql = "SELECT a.nome, plano_fim from estacionamento as e
				JOIN aluno AS a ON e.id_aluno = a.id_aluno
				WHERE estacionamento_status = 'T' OR to_days(e.plano_fim) - to_days(NOW()) <= 0 
				ORDER BY YEAR(e.plano_fim) ASC, MONTH(e.plano_fim) ASC, DAY(e.plano_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}