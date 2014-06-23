-- inserindo o menu de financeiro aos itens do controle de acesso
insert into controle_acesso(componente, tipo_componente, id_grupo_usuario, id_organizacao) values ('menu/financeiro', 'M', 1,0);
-- criando permissao do ao menu de financeiro para os usuarios participantes do grupo de adminitradores
insert into permissao_acesso(id_controle_acesso, permissao, id_organizacao, id_grupo_usuario) select 14, permissao, id_organizacao, 1 from permissao_acesso where id_grupo_usuario = 1 group by id_organizacao;