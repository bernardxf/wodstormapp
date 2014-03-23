update contrato set status = 'I' where id_aluno in (select id_aluno from aluno
where aluno.status = 'I') and status = 'A'