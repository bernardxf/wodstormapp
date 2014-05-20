-- -----------------------------------------------------
-- Table `controle_acesso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `controle_acesso` (
  `id_controle_acesso` INT NOT NULL AUTO_INCREMENT,
  `componente` VARCHAR(150) NULL,
  `tipo_componente` CHAR(1) NULL,
  `permissao` INT(11) ZEROFILL NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_controle_acesso`),
  INDEX `fk_controle_acesso_grupo_usuario1_idx` (`id_grupo_usuario` ASC),
  INDEX `fk_controle_acesso_organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_controle_acesso_organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Criacao do campo de id_grupo_usuario na tabela de usuarios.
alter TABLE `usuario` (
  `id_grupo_usuario` INT(11) NOT NULL,
  CONSTRAINT `fk_usuario_grupo_usuario1`
    FOREIGN KEY (`id_grupo_usuario`)
    REFERENCES `grupo_usuario` (`id_grupo_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 42
DEFAULT CHARACTER SET = utf8;


-- Inserts para controle de acesso.
insert into grupo_usuario(id_grupo_usuario, nome, organizacao) 
  values('1', 'Administradores', '1');
insert into grupo_usuario(id_grupo_usuario, nome, organizacao) 
  values('2', 'Recepcionistas', '1');

insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('1', 'menu/dashboard', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('2', 'menu/aluno', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('3', 'menu/aulaexp', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('4', 'menu/estacionamento', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('5', 'menu/servico', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('6', 'menu/presenca', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('7', 'menu/relatorio/relaluno', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('8', 'menu/relatorio/relmetricacontrato', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('9', 'menu/relatorio/relaula', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('10', 'menu/relatorio/relservico', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('11', 'menu/configuracoes/desconto', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('12', 'menu/configuracoes/formapagamento', 'M', '2', '1', '1');
insert into controle_acesso(id_controle_acesso, componente, tipo_componente, permissao, id_grupo_usuario, id_organizacao) 
  values ('13', 'menu/configuracoes/plano', 'M', '2', '1', '1');

-- Adicionando o usuario crossfitBh ao grupo de administradores.
update usuario
  set id_grupo_usuario = 1
  where id_usuario = 4;
