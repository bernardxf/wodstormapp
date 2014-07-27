<?php
namespace Crossfit\Dados;

use Crossfit\Conexao;
use Crossfit\App;

class Dashboard
{
	public static function retorna()
	{
		$sql = "SELECT 
                (SELECT count(*) FROM contrato WHERE status = 'A' AND id_organizacao = ?) as ativo, 
                (SELECT count(DISTINCT contrato.id_aluno)
                    FROM contrato
                    JOIN aluno on aluno.id_aluno = contrato.id_aluno
                    WHERE contrato.status = 'F'
                    AND contrato.id_organizacao = ?
                    AND not exists (
                        SELECT 1
                        FROM contrato cont
                        WHERE cont.id_aluno = contrato.id_aluno
                        AND cont.status in ('A', 'I')
                        AND cont.id_organizacao = ?)) as finalizado, 
                (SELECT count(*) FROM contrato WHERE status = 'T' AND id_organizacao = ?) as trancado 
                FROM contrato LIMIT 0,1";
		$resultado = Conexao::get()->fetchAssoc($sql, array(App::getSession()->get('organizacao'),App::getSession()->get('organizacao'),App::getSession()->get('organizacao'), App::getSession()->get('organizacao')));
		return $resultado;
	}
}