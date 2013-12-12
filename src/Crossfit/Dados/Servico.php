<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Servico
{
	public static function retornaTodos()
	{
		$sql = 'select servico.*, aluno.nome as aluno from servico join aluno on servico.id_aluno = aluno.id_aluno where servico.id_organizacao = ?';
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaSelecionado($id_servico)
	{
		$sql = 'select * from servico where id_servico = ? and id_organizacao = ?';
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_servico, App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function salvaServico($servicoDataset)
	{
		$resultado = Conexao::get()->insert('servico', $servicoDataset);
		return $ressultado;
	}

	public static function atualizaServico($servicoDataset, $id_servico)
	{
		$resultado = Conexao::get()->update('servico', $servicoDataset, array('id_servico' => $id_servico));
		return $ressultado;
	}

	public static function removeServico($id_servico)
	{
		$resultado = Conexao::get()->delete('servico', array('id_servico' => $id_servico));
		return $resultado;
	}
}