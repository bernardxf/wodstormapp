-- Relatorio de aluno ativos, finalizados e renovados

select (
select count(1)
  from contrato 
  where data_inicio <= '2014-01-30'
	and data_fim >= '2014-01-30'
	and contrato.id_organizacao = 1
) as ativo_periodo,
(

select count(1)
  from contrato 
  where status = 'F'
	and data_fim between '2014-03-01' and '2014-03-30'
	and contrato.id_organizacao = 1
	and not exists (
		select 1
		  from contrato cont
		  where cont.id_aluno = contrato.id_aluno
			and status = 'A'
			and cont.id_organizacao = 1
	  )
) as finalizado,
(
select count(1) 
from contrato 
where status = 'A'
and contrato.id_organizacao = 1
  and data_inicio between '2014-03-01' and '2014-03-30'
  and exists (
    select 1
      from contrato cont
	  where cont.id_aluno = contrato.id_aluno
        and status = 'F'
        and data_fim < '2014-03-01'
		and cont.id_organizacao = 1
  )
) as renovado,
(
select count(1) 
from contrato 
where status = 'A'
and contrato.id_organizacao = 1
  and data_inicio between '2014-03-01' and '2014-03-30'
  and not exists (
    select 1
      from contrato cont
	  where cont.id_aluno = contrato.id_aluno
		and status in ('F', 'I')
		and cont.id_organizacao = 1
  )
) as novos,
(
select count(1)
from contrato 
where status = 'A'
and id_organizacao = 1
) as ativos
from dual;
