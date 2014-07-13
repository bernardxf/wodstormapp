-- inclusao do campo de status no usuario.
alter table usuario add (status char(1) default 'A');