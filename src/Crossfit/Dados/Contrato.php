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

		if($resultado) {
			$sql = "SELECT MAX(id_contrato) FROM contrato WHERE id_organizacao = ? and id_aluno = ?";

			$id_contrato = Conexao::get()->fetchColumn($sql, array(App::getSession()->get('organizacao'), $contratoDataset['id_aluno']));

			$contratoDataset['id_contrato'] = $id_contrato;
			$resultado = $contratoDataset;
		}

		return $resultado;
	}

	public static function finalizaContratosAnteriores($contratoDataset) 
	{
		$idAluno = $contratoDataset["id_aluno"];
		$inicioNovoContrato = $contratoDataset["data_inicio"];
		$idOrganizacao = App::getSession()->get('organizacao');

		$sql = "SELECT max(id_contrato) FROM contrato WHERE id_aluno = ? AND id_organizacao = ?";
        $idNovoContrato = Conexao::get()->fetchColumn($sql, array($idAluno, $idOrganizacao));

		$sql = "UPDATE contrato
		          SET status     = 'F',
		            data_fim     = ?
		          WHERE id_aluno = ?
		            AND status   = 'A'
		            AND id_organizacao = ?
		            AND id_contrato != ?";
		$params = array($inicioNovoContrato, $idAluno, $idOrganizacao, $idNovoContrato);
		return Conexao::get()->executeUpdate($sql, $params);
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
				WHERE aluno.status = 'A'
				AND contrato.status = 'A' AND to_days(data_fim) - to_days(SYSDATE()) <= 7 
				AND contrato.id_organizacao = ?
				ORDER BY YEAR(data_fim) ASC, MONTH(data_fim) ASC, DAY(data_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}
}