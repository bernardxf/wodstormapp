<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class HistoricoContrato
{
	public static function salvar($dataset)
	{
		$resultado = Conexao::get()->insert('historico_contrato', $dataset);
		return $resultado;
	}

	public static function retornaRelatorioMensalContratos($dataInicio, $dataFim)
	{
		$idOrganizacao = App::getSession()->get('organizacao');

		$sql = "SELECT contrato.id_contrato, aluno.id_aluno, aluno.nome from historico_contrato as hc
				join contrato on hc.id_contrato = contrato.id_contrato
				join aluno on hc.id_aluno = aluno.id_aluno
				where hc.id_organizacao = ?
				and hc.status_contrato = 'A'
				and hc.data <= ?
				and (exists (
					select 1 from historico_contrato
					where id_contrato = hc.id_contrato
					and status_contrato = 'F'
					and data > ?
				) or not exists(
					select 1 from historico_contrato
					where id_contrato = hc.id_contrato
					and status_contrato in ('F','T')
				));";
		$ativoPeriodo = Conexao::get()->fetchAll($sql, array($idOrganizacao, $dataFim, $dataFim));

		$sql = "SELECT contrato.id_contrato, aluno.id_aluno, aluno.nome from historico_contrato as hc
				join contrato on hc.id_contrato = contrato.id_contrato
				join aluno on hc.id_aluno = aluno.id_aluno
				where hc.id_organizacao = ?
				and hc.status_contrato = 'F'
				and hc.data between ? and ?
				and not exists (
					select 1 from historico_contrato
					where id_aluno = hc.id_aluno
					and status_contrato in ('A', 'T')
					and data > ?
				);";
		$finalizado = Conexao::get()->fetchAll($sql, array($idOrganizacao, $dataInicio, $dataFim, $dataInicio));

		
		$sql = "SELECT contrato.id_contrato, aluno.id_aluno, aluno.nome from historico_contrato as hc
				join contrato on hc.id_contrato = contrato.id_contrato
				join aluno on hc.id_aluno = aluno.id_aluno
				where hc.id_organizacao = ?
				and hc.status_contrato in ('A','T')
				and hc.data between ? and ?
				and exists (
					select 1 from historico_contrato
					where id_aluno = hc.id_aluno
					and status_contrato = 'F'
					and data <  hc.data
				);";
		$renovado = Conexao::get()->fetchAll($sql, array($idOrganizacao, $dataInicio, $dataFim));

		$sql = "SELECT contrato.id_contrato, aluno.id_aluno, aluno.nome from historico_contrato as hc
				join contrato on hc.id_contrato = contrato.id_contrato
				join aluno on hc.id_aluno = aluno.id_aluno
				where hc.id_organizacao = ?
				and hc.data between ? and ?
				and hc.status_contrato = 'A'
				and not exists (
					select 1 from historico_contrato
					where id_aluno = hc.id_aluno
					and data <= ?
				);";
		$novos = Conexao::get()->fetchAll($sql, array($idOrganizacao, $dataInicio, $dataFim, $dataInicio));

		$sql = "SELECT contrato.id_contrato, aluno.id_aluno, aluno.nome from historico_contrato as hc
				join contrato on hc.id_contrato = contrato.id_contrato
				join aluno on hc.id_aluno = aluno.id_aluno
				where hc.id_organizacao = ?
				and hc.status_contrato = 'A'
				and not exists (
					select 1 from historico_contrato
					where id_contrato = hc.id_contrato
					and status_contrato in ('F', 'T')
				);";
 		$ativos = Conexao::get()->fetchAll($sql, array($idOrganizacao));


		$resultado = compact('ativoPeriodo','finalizado','renovado','novos','ativos');
		return $resultado;
	}
}