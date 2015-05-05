<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Leaderboard
{
	public static function retornaListaDatas()
	{
		$sql = "SELECT data from leaderboard where id_organizacao = ? group by data";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));

		return $resultado;
	}

	public static function retornaLeaderboardPorData($data)
	{
		$sql = "SELECT aluno.nome as aluno, l.rx, l.observacao, l.reps, if(l.min = 0, '', CONCAT_WS(':', LPAD(l.min, 2, '0'), LPAD(l.sec, 2, '0'))) as tempo from Leaderboard as l
				join aluno on aluno.id_aluno = l.id_aluno
				where l.id_organizacao = ? and l.data = ?
				order by l.reps DESC, l.min, l.sec;";
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao'), $data));

		return $resultado;
	}

	public static function retornaLeaderboardPorDataEOrganizacao($data, $id_organizacao)
	{
		$sql = "SELECT aluno.nome as aluno, l.rx, l.observacao, l.reps, if(l.min = 0, '', CONCAT_WS(':', LPAD(l.min, 2, '0'), LPAD(l.sec, 2, '0'))) as tempo from Leaderboard as l
				join aluno on aluno.id_aluno = l.id_aluno
				where l.id_organizacao = ? and l.data = ?
				order by l.reps DESC, l.min, l.sec;";
		$resultado = Conexao::get()->fetchAll($sql, array($id_organizacao, $data));

		return $resultado;
	}

	public static function salvaResultado($leaderboardDataset)
	{	
		$sql = "SELECT * from leaderboard where id_aluno = ? and id_organizacao = ? and data = ?";

		$jaExiste = Conexao::get()->fetchAll($sql, array($leaderboardDataset['id_aluno'],$leaderboardDataset['id_organizacao'], $leaderboardDataset['data']));

		if(count($jaExiste) > 0) {
			unset($leaderboardDataset['id_aluno']);
			unset($leaderboardDataset['id_organizacao']);
			$resultado = Conexao::get()->update('leaderboard', $leaderboardDataset, array('id_leaderboard', $jaExiste[0]['id_leaderboard']));
		} else $resultado = Conexao::get()->insert('leaderboard', $leaderboardDataset);
		return $resultado;
	}

}