<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Aluno
{
	public static function retornaTodos()
	{
        $sql = "SELECT aluno.id_aluno, aluno.nome, aluno.email, aluno.tel_celular, IFNULL(contrato.data_fim, '') as data_fim, IFNULL(contrato.status, '')  as status
				FROM aluno
				LEFT OUTER JOIN (select data_fim, id_aluno, status from contrato
					  ORDER BY id_contrato DESC) as contrato ON contrato.id_aluno = aluno.id_aluno  
				WHERE aluno.id_organizacao = ?
				and aluno.status != ?
				group by aluno.id_aluno
				ORDER BY aluno.nome;
				";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), 'I'));
		return $resultado;
	}

	public static function retornaAlunosPresenca($nome, $data = null)
	{
		$sql = "SELECT a.id_aluno as id_aluno, a.nome as nome, a.observacao_presenca as observacao_presenca, plano.nome as plano, contrato.data_fim as data_fim, plano.dias_por_periodo, 
				(
					-- select aluno.nome, count(1) as total_aulas_periodo, if(date_format(contrato.data_inicio, '%d') < date_format(curdate(), '%d'),CONCAT_WS('-',date_format(curdate(), '%Y-%m'), date_format(contrato.data_inicio, '%d')),CONCAT_WS('-',date_format(DATE_SUB(curdate(),INTERVAL 1 MONTH), '%Y-%m'), date_format(contrato.data_inicio, '%d'))) as periodo from alunos_aula
					select count(1) from alunos_aula
					join contrato on contrato.id_aluno = alunos_aula.id_aluno
					join aula on aula.id_aula = alunos_aula.id_aula
					where contrato.status = 'A'
					and alunos_aula.id_aluno = a.id_aluno
					and aula.data between if(date_format(contrato.data_inicio, '%d') < date_format(?, '%d'),CONCAT_WS('-',date_format(?, '%Y-%m'), date_format(contrato.data_inicio, '%d')),CONCAT_WS('-',date_format(DATE_SUB(?,INTERVAL 1 MONTH), '%Y-%m'), date_format(contrato.data_inicio, '%d'))) and ?
				) as total_aulas_periodo,
				(
					select aula.horario from alunos_aula
					join aula on aula.id_aula = alunos_aula.id_aula
					where aula.data = ?
					and id_aluno = a.id_aluno
				) presente
				FROM aluno as a
				JOIN contrato on contrato.id_aluno = a.id_aluno
				JOIN plano on contrato.id_plano = plano.id_plano
				WHERE a.nome LIKE ? AND a.status = ? AND contrato.status = ? AND a.id_organizacao = ?
				ORDER BY a.nome";
		$id_organizacao = App::getSession()->get('organizacao');
		$resultado = Conexao::get()->fetchAll($sql, array($data,$data,$data,$data,$data, '%'.$nome.'%', 'A', 'A',$id_organizacao));
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
		$sql = "select id_aluno, nome from aluno where status = ? and id_organizacao = ? order by nome";
		$resultado = Conexao::get()->fetchAll($sql, array('A', App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaAniversariantes()
	{
		$sql = "SELECT aluno.nome, DATE_FORMAT(aluno.data_nasc, '%d/%m') data_nasc -- aluno.data_nasc
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