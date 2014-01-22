
<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Contrato
{
	public static function retornaTodosPorAluno($id_aluno)
	{
		$sql = "select * from contrato where id_aluno = ? and id_organizacao = ?";
		$resultado = Conexao::get()->fetchAll($sql, array($id_aluno, App::getSession()->get('organizacao')));

		return $resultado;
	}

	public static function retornaSelecionado($id_contrato)
	{
		$sql = "SELECT * FROM contrato where id_contrato = ? and id_organizacao = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_contrato, App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function salvaContrato($contratoDataset)
	{
		$resultado = Conexao::get()->insert('contrato', $contratoDataset);
		return $resultado;
	}

	public static function atualizaContrato($id_contrato, $contratoDataset)
	{
		$resultado = Conexao::get()->update('contrato', $contratoDataset, array('id_contrato' => $id_contrato));
		return $resultado;
	}

	public static function removeContrato($id_contrato)
	{
		$resultado = Conexao::get()->delete('contrato', array('id_contrato' => $id_contrato));
		return $resultado;
	}

	public static function retornaVencimentoContrato()
	{
		$sql = "SELECT aluno.nome as nome, data_fim FROM contrato 
				JOIN aluno on contrato.id_aluno = aluno.id_aluno
				WHERE contrato.status = 'A' AND to_days(data_fim) - to_days(SYSDATE()) <= 7 
				AND contrato.id_organizacao = ?
				AND contrato.status = ?
				ORDER BY YEAR(data_fim) ASC, MONTH(data_fim) ASC, DAY(data_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), 'A'));
		return $resultado;
	}
}