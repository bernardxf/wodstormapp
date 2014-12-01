<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;
use Crossfit\Dados\HistoricoContrato;

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

        $sql = "SELECT * from contrato where id_aluno = ? and status = 'A'";
        $contratoAtivo = Conexao::get()->fetchAssoc($sql, array($idAluno));

        if($contratoAtivo) {
        	$contratoAtivo['status'] = 'F';
        	$contratoAtivo['data_fim'] = $inicioNovoContrato;
        	Conexao::get()->update('contrato', $contratoAtivo, array('id_contrato' => $contratoAtivo['id_contrato']));

			$historicoDataset = array(
				'id_contrato' => $contratoAtivo['id_contrato'],
				'id_aluno' => $contratoAtivo['id_aluno'],
				'data' => $inicioNovoContrato,
				'status_contrato' => $contratoAtivo['status'],
				'id_organizacao' => $idOrganizacao
			);	

			$resultado = HistoricoContrato::salvar($historicoDataset);
        }
		return true;
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