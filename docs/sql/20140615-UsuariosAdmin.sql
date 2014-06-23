update usuario set id_grupo_usuario = 2;

insert into usuario (nome, usuario, senha, id_organizacao, id_grupo_usuario) 
select CONCAT('Admin ', usuario.nome) as nome, CONCAT('admin', usuario.usuario) as usuario, senha, id_organizacao, 1 from usuario;