<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;

class FormaPagamento
{
	public static function retornaTodos()
	{
		$sql = "select * from forma_pagamento"; 
		$resultado = Conexao::get()->fetchAll($sql);
		return $resultado;
	}

	public static function retornaSelecionado($id_forma_pagamento)
	{
		$sql = "select * from forma_pagamento where id_forma_pagamento = ?";
		$resultado = Conexao::get()->fetchAssoc($sql, array($id_forma_pagamento));
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