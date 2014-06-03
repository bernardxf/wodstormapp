alter table aluno add column observacao_presenca varchar(200) after observacao;

-- CRIACAO DA ESTRUTURA DE CONTROLE DE ACESSO.
CREATE  TABLE IF NOT EXISTS `grupo_usuario` (
  `id_grupo_usuario` INT(11) NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NULL ,
  `id_organizacao` INT(11) NOT NULL ,
  PRIMARY KEY (`id_grupo_usuario`) ,
  INDEX `fk_grupo_usuario_organizacao1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_grupo_usuario_organizacao1`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `controle_acesso` (
  `id_controle_acesso` INT NOT NULL AUTO_INCREMENT ,
  `componente` VARCHAR(150) NULL ,
  `tipo_componente` CHAR(1) NULL ,
  `permissao` INT(11) ZEROFILL NULL ,
  `id_grupo_usuario` INT(11) NOT NULL ,
  `id_organizacao` INT(11) NOT NULL ,
  PRIMARY KEY (`id_controle_acesso`) ,
  INDEX `fk_controle_acesso_grupo_usuario1_idx` (`id_grupo_usuario` ASC) ,
  INDEX `fk_controle_acesso_organizacao1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_controle_acesso_grupo_usuario1`
    FOREIGN KEY (`id_grupo_usuario` )
    REFERENCES `grupo_usuario` (`id_grupo_usuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_controle_acesso_organizacao1`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

alter table usuario add (id_grupo_usuario int(11));
alter table usuario add CONSTRAINT 'fk_grupo_usuario_usuario' FOREIGN KEY (id_grupo_usuario) REFERENCES grupo_usuario(id_grupo_usuario);

update usuario set id_grupo_usuario = 1 where id_usuario = 4;

insert into grupo_usuario (id_grupo_usuario, nome, id_organizacao) values (1, 'Administradores', 1);
insert into grupo_usuario (id_grupo_usuario, nome, id_organizacao) values (2, 'Recepcionistas', 1);

insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/dashboard', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/aluno', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/aulaexp', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/estacionamento', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/servico', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/presenca', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/relatorio/relaluno', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/relatorio/relmetricacontrato', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/relatorio/relaula', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/relatorio/relservico', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/configuracoes/desconto', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/configuracoes/formapagamento', 'M', 2, 1, 1);
insert into controle_acesso (componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) values ('menu/configuracoes/plano', 'M', 2, 1, 1);