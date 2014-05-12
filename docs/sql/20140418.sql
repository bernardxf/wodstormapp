SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `wodstorm` DEFAULT CHARACTER SET utf8 ;
USE `wodstorm` ;

-- -----------------------------------------------------
-- Table `wodstorm`.`organizacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`organizacao` (
  `id_organizacao` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60) NOT NULL,
  `email` VARCHAR(60) NULL DEFAULT NULL,
  `telefone` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id_organizacao`))
ENGINE = InnoDB
AUTO_INCREMENT = 10000
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`aluno` (
  `id_aluno` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `data_nasc` DATE NOT NULL,
  `rg` VARCHAR(15) NOT NULL,
  `cpf` VARCHAR(15) NOT NULL,
  `estado_civil` VARCHAR(100) NULL DEFAULT NULL,
  `email` VARCHAR(150) NULL DEFAULT NULL,
  `cep` VARCHAR(10) NOT NULL,
  `logradouro` VARCHAR(250) NULL DEFAULT NULL,
  `complemento` VARCHAR(150) NULL DEFAULT NULL,
  `bairro` VARCHAR(150) NULL DEFAULT NULL,
  `cidade` VARCHAR(150) NULL DEFAULT NULL,
  `uf` VARCHAR(2) NULL DEFAULT NULL,
  `tel_fixo` VARCHAR(100) NULL DEFAULT NULL,
  `tel_celular` VARCHAR(100) NULL DEFAULT NULL,
  `pessoa_ref` VARCHAR(150) NULL DEFAULT NULL,
  `tel_ref` VARCHAR(100) NULL DEFAULT NULL,
  `plano_saude` VARCHAR(150) NULL DEFAULT NULL,
  `atestado_medico` VARCHAR(50) NULL DEFAULT NULL,
  `observacao` VARCHAR(200) NULL DEFAULT NULL,
  `observacao_presenca` VARCHAR(45) NULL,
  `status` VARCHAR(1) NOT NULL DEFAULT 'A',
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_aluno`),
  INDEX `fk_aluno_1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_id_organizacao_aluno`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5022
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`aula`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`aula` (
  `id_aula` INT(11) NOT NULL AUTO_INCREMENT,
  `data` DATE NULL DEFAULT NULL,
  `horario` VARCHAR(10) NULL DEFAULT NULL,
  `excedente` INT(11) NOT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_aula`),
  INDEX `fk_aula_1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_id_organizacao_aula`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 11692
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`alunos_aula`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`alunos_aula` (
  `id_aluno_aula` INT(11) NOT NULL AUTO_INCREMENT,
  `num_senha` INT(2) NOT NULL,
  `id_aluno` INT(11) NOT NULL,
  `id_aula` INT(11) NOT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_aluno_aula`),
  INDEX `id_aluno_fk` (`id_aluno` ASC),
  INDEX `id_aula_fk` (`id_aula` ASC),
  INDEX `fk_alunos_aula_1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_id_aluno_alunos_aula`
    FOREIGN KEY (`id_aluno`)
    REFERENCES `wodstorm`.`aluno` (`id_aluno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_aula_alunos_aula`
    FOREIGN KEY (`id_aula`)
    REFERENCES `wodstorm`.`aula` (`id_aula`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_id_organizacao_alunos_aula`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 358852
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `wodstorm`.`aulaexp`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`aulaexp` (
  `id_aulaexp` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NULL DEFAULT NULL,
  `data_aula` DATE NULL DEFAULT NULL,
  `telefone` VARCHAR(13) NOT NULL,
  `observacao` LONGTEXT NULL DEFAULT NULL,
  `confirmado` VARCHAR(50) NULL DEFAULT NULL,
  `presente` VARCHAR(50) NULL DEFAULT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_aulaexp`),
  INDEX `fk_aulaexp_1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_id_organizacao_aulaexp`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3692
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`desconto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`desconto` (
  `id_desconto` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NULL DEFAULT NULL,
  `porc_desc` INT(11) NULL DEFAULT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_desconto`),
  INDEX `fk_desconto_1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_id_organizacao_desconto`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 112
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`forma_pagamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`forma_pagamento` (
  `id_forma_pagamento` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_forma_pagamento`),
  INDEX `fk_forma_pagamento_1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_id_organizacao_forma_pagamento`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 53
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`plano`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`plano` (
  `id_plano` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NULL DEFAULT NULL,
  `tipo` INT(11) NULL DEFAULT NULL,
  `valor` DECIMAL(9,2) NULL DEFAULT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_plano`),
  INDEX `fk_plano_1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_id_organizacao_plano`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 852
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`contrato`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`contrato` (
  `id_contrato` INT(11) NOT NULL AUTO_INCREMENT,
  `data_inicio` DATE NOT NULL,
  `data_fim` DATE NOT NULL,
  `horario_economico` VARCHAR(1) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `dias_trancado` INT(11) NULL DEFAULT NULL,
  `observacao` VARCHAR(200) NULL DEFAULT NULL,
  `id_aluno` INT(11) NOT NULL,
  `id_plano` INT(11) NOT NULL,
  `id_forma_pagamento` INT(11) NOT NULL,
  `id_desconto` INT(11) NOT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_contrato`),
  INDEX `fk_contrato_1_idx` (`id_aluno` ASC),
  INDEX `fk_contrato_2_idx` (`id_plano` ASC),
  INDEX `fk_contrato_1_idx1` (`id_forma_pagamento` ASC),
  INDEX `fk_contrato_1_idx2` (`id_desconto` ASC),
  INDEX `fk_contrato_1_idx3` (`id_organizacao` ASC),
  CONSTRAINT `fk_id_aluno_contrato`
    FOREIGN KEY (`id_aluno`)
    REFERENCES `wodstorm`.`aluno` (`id_aluno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_desconto_contrato`
    FOREIGN KEY (`id_desconto`)
    REFERENCES `wodstorm`.`desconto` (`id_desconto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_forma_pagamento_contrato`
    FOREIGN KEY (`id_forma_pagamento`)
    REFERENCES `wodstorm`.`forma_pagamento` (`id_forma_pagamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_organizacao_contrato`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_plano_contrato`
    FOREIGN KEY (`id_plano`)
    REFERENCES `wodstorm`.`plano` (`id_plano`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5874
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`estacionamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`estacionamento` (
  `id_estacionamento` INT(11) NOT NULL AUTO_INCREMENT,
  `modelo` VARCHAR(150) NULL DEFAULT NULL,
  `cor` VARCHAR(150) NULL DEFAULT NULL,
  `placa` VARCHAR(8) NULL DEFAULT NULL,
  `plano_ini` DATE NOT NULL,
  `plano_fim` DATE NOT NULL,
  `valor` DECIMAL(9,2) NOT NULL,
  `estacionamento_status` VARCHAR(50) NOT NULL,
  `observacao` VARCHAR(200) NULL DEFAULT NULL,
  `id_aluno` INT(11) NOT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_estacionamento`),
  INDEX `fk_id_aluno_estacionamento` (`id_aluno` ASC),
  INDEX `fk_id_organizacao_estacionamento` (`id_organizacao` ASC),
  CONSTRAINT `fk_id_aluno_estacionamento`
    FOREIGN KEY (`id_aluno`)
    REFERENCES `wodstorm`.`aluno` (`id_aluno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_organizacao_estacionamento`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 612
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`servico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`servico` (
  `id_servico` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(60) NOT NULL,
  `valor` DECIMAL(9,2) NOT NULL,
  `data` DATE NOT NULL,
  `descricao` VARCHAR(200) NULL DEFAULT NULL,
  `id_aluno` INT(11) NOT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_servico`),
  INDEX `fk_servico_1_idx` (`id_organizacao` ASC),
  INDEX `fk_servico_1_idx1` (`id_aluno` ASC),
  CONSTRAINT `fk_id_aluno_servico`
    FOREIGN KEY (`id_aluno`)
    REFERENCES `wodstorm`.`aluno` (`id_aluno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_organizacao_servico`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`grupo_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`grupo_usuario` (
  `id_grupo_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_grupo_usuario`),
  INDEX `fk_grupo_usuario_organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_grupo_usuario_organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wodstorm`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`usuario` (
  `id_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `usuario` VARCHAR(150) NOT NULL,
  `senha` VARCHAR(150) NOT NULL,
  `id_organizacao` INT(11) NOT NULL,
  `id_grupo_usuario` INT(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  INDEX `fk_usuario_1_idx` (`id_organizacao` ASC),
  INDEX `fk_usuario_grupo_usuario1_idx` (`id_grupo_usuario` ASC),
  CONSTRAINT `fk_id_organizacao_usuario`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_grupo_usuario1`
    FOREIGN KEY (`id_grupo_usuario`)
    REFERENCES `wodstorm`.`grupo_usuario` (`id_grupo_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 42
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`controle_acesso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`controle_acesso` (
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
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wodstorm`.`Organizacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`Organizacao` (
  `id_organizacao` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_organizacao`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wodstorm`.`Pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`Pessoa` (
  `id_pessoa` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NULL,
  `telefone` VARCHAR(20) NULL,
  `tel_celular` VARCHAR(20) NULL,
  `email` VARCHAR(60) NULL,
  `data_nasc` DATE NULL,
  `rg` VARCHAR(20) NULL,
  `cpf` VARCHAR(20) NULL,
  `id_organizacao` INT NOT NULL,
  PRIMARY KEY (`id_pessoa`),
  INDEX `fk_Pessoa_Organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_Pessoa_Organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`Organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Define qualquer tipo de instância de pessoa. Podem ser usuár /* comment truncated */ /*ios do sistema, clientes, funcionários, e outros, caso existam.*/';


-- -----------------------------------------------------
-- Table `wodstorm`.`Grupo_Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`Grupo_Usuario` (
  `id_grupo_usuario` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `id_organizacao` INT NOT NULL,
  PRIMARY KEY (`id_grupo_usuario`),
  INDEX `fk_Grupo_Usuario_Organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_Grupo_Usuario_Organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`Organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Define grupos de usuários do sistema. Posteriormente, este p /* comment truncated */ /*ode ser utilizado para configurar permissões de acesso do sistema.*/';


-- -----------------------------------------------------
-- Table `wodstorm`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`Usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT NOT NULL,
  `id_grupo_usuario` INT NOT NULL,
  `senha` VARCHAR(100) NULL,
  `id_organizacao` INT NOT NULL,
  PRIMARY KEY (`id_usuario`),
  INDEX `fk_Usuario_Pessoa1_idx` (`id_pessoa` ASC),
  INDEX `fk_Usuario_Grupo_Usuario1_idx` (`id_grupo_usuario` ASC),
  INDEX `fk_Usuario_Organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_Usuario_Pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wodstorm`.`Pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_Grupo_Usuario1`
    FOREIGN KEY (`id_grupo_usuario`)
    REFERENCES `wodstorm`.`Grupo_Usuario` (`id_grupo_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_Organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`Organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wodstorm`.`Cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`Cliente` (
  `id_cliente` INT NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT NOT NULL,
  `id_organizacao` INT NOT NULL,
  PRIMARY KEY (`id_cliente`),
  INDEX `fk_Cliente_Pessoa1_idx` (`id_pessoa` ASC),
  INDEX `fk_Cliente_Organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_Cliente_Pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wodstorm`.`Pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cliente_Organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`Organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wodstorm`.`Funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`Funcionario` (
  `id_funcionario` INT NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT NOT NULL,
  `id_organizacao` INT NOT NULL,
  PRIMARY KEY (`id_funcionario`),
  INDEX `fk_Funcionario_Pessoa1_idx` (`id_pessoa` ASC),
  INDEX `fk_Funcionario_Organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_Funcionario_Pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wodstorm`.`Pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Funcionario_Organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`Organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Define todos os funcionários da empresa/filial';


-- -----------------------------------------------------
-- Table `wodstorm`.`Agenda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`Agenda` (
  `id_agenda` INT NOT NULL AUTO_INCREMENT,
  `hora_inicio` DATETIME NULL,
  `hora_fim` DATETIME NULL,
  `id_cliente` INT NOT NULL,
  `id_funcionario` INT NOT NULL,
  `status` VARCHAR(45) NULL,
  `observacao` VARCHAR(4000) NULL,
  `id_organizacao` INT NOT NULL,
  PRIMARY KEY (`id_agenda`),
  INDEX `fk_Agenda_Cliente1_idx` (`id_cliente` ASC),
  INDEX `fk_Agenda_Funcionario1_idx` (`id_funcionario` ASC),
  INDEX `fk_Agenda_Organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_Agenda_Cliente1`
    FOREIGN KEY (`id_cliente`)
    REFERENCES `wodstorm`.`Cliente` (`id_cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Agenda_Funcionario1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wodstorm`.`Funcionario` (`id_funcionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Agenda_Organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`Organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Esta tabela define o quadro de horários agendados para os at /* comment truncated */ /*endimentos.*/';


-- -----------------------------------------------------
-- Table `wodstorm`.`Horario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`Horario` (
  `id_horario` INT NOT NULL AUTO_INCREMENT,
  `dia_semana` VARCHAR(15) NULL,
  `hora_inicio` DATETIME NULL,
  `hora_fim` DATETIME NULL,
  `id_funcionario` INT NOT NULL,
  `id_organizacao` INT NOT NULL,
  PRIMARY KEY (`id_horario`),
  INDEX `fk_Horario_Funcionario1_idx` (`id_funcionario` ASC),
  INDEX `fk_Horario_Organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_Horario_Funcionario1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wodstorm`.`Funcionario` (`id_funcionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Horario_Organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`Organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Esta tabela define os horários de trabalho de um funcionário /* comment truncated */ /*, dentro da semana. Os horários serão definidos nesta tabela através dos intervalos de horários. Ex.: Para um funcionário que trabalha às segundas-feiras, de 08 às 17:00, com almoço entre as 12:00 e 13:00, deverá existir um registro de SEGUNDA-FEIRA, com hora_inicio = 08:00 e hora_fim = 12:00, e um segundo registro  de SEGUNDA-FEIRA, com hora_inicio = 13:00 e hora_fim = 17:00*/';


-- -----------------------------------------------------
-- Table `wodstorm`.`Estrutura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wodstorm`.`Estrutura` (
  `id_estrutura` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NULL,
  `email` VARCHAR(60) NULL,
  `telefone` VARCHAR(20) NULL,
  `id_estrutura_pai` INT NULL,
  `id_organizacao` INT NOT NULL,
  PRIMARY KEY (`id_estrutura`),
  INDEX `fk_Estrutura_Estrutura1_idx` (`id_estrutura_pai` ASC),
  INDEX `fk_Estrutura_Organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_Estrutura_Estrutura1`
    FOREIGN KEY (`id_estrutura_pai`)
    REFERENCES `wodstorm`.`Estrutura` (`id_estrutura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Estrutura_Organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`Organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Define as diferentes formas de estrutura de trabalho de uma  /* comment truncated */ /*organização. Pode definir uma empresa, filial, etc.*/';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- Criacao do campo de id_grupo_usuario na tabela de usuarios.
alter TABLE `wodstorm`.`usuario` (
  `id_grupo_usuario` INT(11) NOT NULL,
  CONSTRAINT `fk_usuario_grupo_usuario1`
    FOREIGN KEY (`id_grupo_usuario`)
    REFERENCES `wodstorm`.`grupo_usuario` (`id_grupo_usuario`)
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
