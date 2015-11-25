<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class FormaPagamento
{
	public static function retornaTodos()
	{
		$sql = "select * from forma_pagamento where id_organizacao = ?"; 
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function retornaTodosSimples()
	{
		$sql = "select id_forma_pagamento, nome from forma_pagamento where id_organizacao = ?"; 
		$resultado = Conexao::get()->fetchAll($sql, array(App::getSession()->get('organizacao')));
		return $resultado;	
	}

	public static function retornaSelecionado($id_forma_pagamento)
	{
		$sql = "select * from forma_pagamento where id_forma_pagamento = ? and id_organizacao = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_forma_pagamento, App::getSession()->get('organizacao')));
		return $resultado;
	}

	public static function salvaFormaPagamento($formapagamentoDataset)
	{
		$resultado = Conexao::get()->insert('forma_pagamento', $formapagamentoDataset);
		return $resultado;
	}

	public static function atualizaFormaPagamento($formapagamentoDataset, $id_forma_pagamento)
	{
		$resultado = Conexao::get()->update('forma_pagamento', $formapagamentoDataset, array('id_forma_pagamento' => $id_forma_pagamento));
		return $resultado;
	}

	public static function removeFormaPagamento($id_forma_pagamento)
	{
		$resultado = Conexao::get()->delete('forma_pagamento', array('id_forma_pagamento' => $id_forma_pagamento));
		return $resultado;
	}
}