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
		$sql = "SELECT E.id_aluno_fk, DATE_FORMAT(E.plano_fim, '%d/%m/%Y') as plano_fim, A.nome FROM estacionamento AS E INNER JOIN aluno AS A ON (E.id_aluno_fk = A.id_aluno) WHERE estacionamento_status = 'trancado' OR to_days(E.plano_fim) - to_days(NOW()) <= 0 ORDER BY YEAR(E.plano_fim) ASC, MONTH(E.plano_fim) ASC, DAY(E.plano_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}
}