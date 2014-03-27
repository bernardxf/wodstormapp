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

	public static function retornaRelatorioMensalContratos($dataInicio, $dataFim)
	{
		$sql = "SELECT (
					SELECT count(1)
					  FROM contrato 
					  WHERE status = ?
						AND data_inicio <= ?
						AND contrato.id_organizacao = ?
					) as ativo,
					(
						SELECT count(1)
						  FROM contrato 
						  WHERE status = ?
							AND data_fim between ? AND ?
							AND contrato.id_organizacao = ?
							AND not exists (
								SELECT 1
								  FROM contrato cont
								  WHERE cont.id_aluno = contrato.id_aluno
									AND status = ?
									AND cont.id_organizacao = ?
						  	)
					) as finalizado,
					(
						SELECT count(1) 
						FROM contrato 
						WHERE status = ?
						AND contrato.id_organizacao = ?
						  AND data_inicio between ? AND ?
						  AND exists (
						    SELECT 1
						      FROM contrato cont
							  WHERE cont.id_aluno = contrato.id_aluno
						        AND status = ?
						        AND data_fim < ?
								AND cont.id_organizacao = ?
						  )
					) as renovado,
					(
						SELECT count(1) 
						FROM contrato 
						WHERE status = ?
						AND contrato.id_organizacao = ?
						  AND data_inicio between ? AND ?
						  AND not exists (
						    SELECT 1
						      FROM contrato cont
							  WHERE cont.id_aluno = contrato.id_aluno
								AND status in (?, ?)
								AND cont.id_organizacao = ?
						  )
					) as novos
					FROM dual";
		$idOrganizacao = App::getSession()->get('organizacao');
		$resultado = Conexao::get()->fetchAll($sql, array(
			'A', $dataFim, $idOrganizacao, 'F', $dataInicio, $dataFim, $idOrganizacao, 'A', $idOrganizacao, 'A', $idOrganizacao, $dataInicio, $dataFim, 'F',
			$dataInicio, $idOrganizacao, 'A', $idOrganizacao, $dataInicio, $dataFim, 'F', 'I', $idOrganizacao
		));
		return $resultado;
	}

	public static function retornaVencimentoContrato()
	{
		$sql = "SELECT aluno.nome as nome, data_fim FROM contrato 
				JOIN aluno on contrato.id_aluno = aluno.id_aluno
				WHERE contrato.status = 'A' AND to_days(data_fim) - to_days(SYSDATE()) <= 7 
				AND contrato.id_organizacao = ?
				ORDER BY YEAR(data_fim) ASC, MONTH(data_fim) ASC, DAY(data_fim) ASC";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}
}