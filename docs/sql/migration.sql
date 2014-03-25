insert into organizacao (id_organizacao, nome, email) values (3, 'TheBox', 'contato@theboxcrossfit.com.br');
insert into usuario(nome, usuario, senha, id_organizacao) values('TheBox Crossfit', 'thebox', 'e10adc3949ba59abbe56e057f20f883e', 3);

insert into usuario (nome, usuario, senha, id_organizacao) select nome, usuario, senha, '3' from crossfit.usuario order by crossfit.usuario.id_usuario;

insert into aulaexp (nome, data_aula, telefone, observacao, confirmado, presente, id_organizacao) select nome, data_aula, telefone, email, confirmado, presente, '3' from crossfit.aulaexp order by crossfit.aulaexp.id_aulaexp;

alter table forma_pagamento add column old_id int(11);
insert into forma_pagamento (nome, id_organizacao, old_id) select nome, '3', id_forma_pagamento from crossfit.forma_pagamento order by crossfit.forma_pagamento.id_forma_pagamento;

alter table plano add column old_id int(11);
insert into plano (nome, tipo, valor, id_organizacao, old_id) select nome, tipo, valor, '3', id_plano from crossfit.plano order by crossfit.plano.id_plano;

alter table desconto add column old_id int(11);
insert into desconto (nome, porc_desc, id_organizacao, old_id) select nome, porc_desc, '3', id_desconto from crossfit.desconto order by crossfit.desconto.id_desconto;

alter table aluno add column old_id int(11);
insert into aluno (nome, data_nasc, rg, cpf, estado_civil, email, cep, logradouro, complemento, bairro, cidade, uf, tel_fixo, tel_celular, pessoa_ref, tel_ref, plano_saude, atestado_medico, observacao, id_organizacao, old_id)
	select nome, data_nasc, rg, cpf, estado_civil, email, cep, logradouro, complemento, bairro, cidade, uf, tel_fixo, tel_celular, pessoa_ref, tel_ref, plano_saude, atestado_medico, observacao, '3', id_aluno from crossfit.aluno order by crossfit.aluno.id_aluno;

alter table aula add column old_id int(11);
insert into aula (data, horario, excedente, id_organizacao, old_id) select data, horario, excedente, '3', id_aula from crossfit.aula order by crossfit.aula.id_aula;


insert into alunos_aula (num_senha, id_aluno, id_aula, id_organizacao) select num_senha, (select id_aluno from aluno where old_id = id_aluno_fk), (select id_aula from aula where old_id = id_aula_fk), '3' from crossfit.alunos_aula;

insert into estacionamento (modelo, cor, placa, plano_ini, plano_fim, valor, estacionamento_status, observacao, id_aluno, id_organizacao)
	select modelo, cor, placa, plano_ini, plano_fim, valor, estacionamento_status, observacao, (select id_aluno from aluno where old_id = id_aluno_fk), '3' from crossfit.estacionamento;

insert into contrato (data_inicio, data_fim, horario_economico, status, dias_trancado, observacao, id_aluno, id_plano, id_forma_pagamento, id_desconto, id_organizacao)
	select plano_ini, plano_fim, horario_economico, aluno_status, dias_trancado, observacao, (select id_aluno from aluno where old_id = crossfit.aluno.id_aluno), (select id_plano from plano where old_id = id_plano_fk), (select id_forma_pagamento from forma_pagamento where old_id = id_forma_pagamento_fk), (select id_desconto from desconto where old_id = id_desconto_fk), '3' from crossfit.aluno;

alter table forma_pagamento drop column old_id;
alter table plano drop column old_id;
alter table desconto drop column old_id;
alter table aluno drop column old_id;
alter table aula drop column old_id;

update contrato set status = 'A' where status = 'ativo';
update contrato set status = 'I' where status = 'inativo';
update contrato set status = 'T' where status = 'trancado';

update contrato set horario_economico = 'S' where horario_economico = 's';
update contrato set horario_economico = 'N' where horario_economico = 'n';

update estacionamento set estacionamento_status = 'A' where estacionamento_status = 'ativo';
update estacionamento set estacionamento_status = 'I' where estacionamento_status = 'inativo';
update estacionamento set estacionamento_status = 'T' where estacionamento_status = 'trancado';