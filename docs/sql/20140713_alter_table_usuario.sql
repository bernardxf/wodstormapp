-- inclusao do campo de status no usuario.
alter table usuario add (status char(1) default 'A');

insert into controle_acesso (componente, tipo_componente, id_grupo_usuario, id_organizacao) values ('menu/usuario', 'M', 1, 0);
