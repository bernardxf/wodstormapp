SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `wodstorm` ;
CREATE SCHEMA IF NOT EXISTS `wodstorm` DEFAULT CHARACTER SET utf8 ;
USE `wodstorm` ;

-- -----------------------------------------------------
-- Table `wodstorm`.`organizacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`organizacao` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`organizacao` (
  `id_organizacao` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(60) NOT NULL ,
  `email` VARCHAR(60) NULL ,
  `telefone` VARCHAR(20) NULL ,
  PRIMARY KEY (`id_organizacao`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`aluno`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`aluno` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`aluno` (
  `id_aluno` INT(11) NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(150) NOT NULL ,
  `data_nasc` DATE NOT NULL ,
  `rg` VARCHAR(15) NOT NULL ,
  `cpf` VARCHAR(15) NOT NULL ,
  `estado_civil` VARCHAR(100) NULL DEFAULT NULL ,
  `email` VARCHAR(150) NULL ,
  `cep` VARCHAR(10) NOT NULL ,
  `logradouro` VARCHAR(250) NULL DEFAULT NULL ,
  `complemento` VARCHAR(150) NULL DEFAULT NULL ,
  `bairro` VARCHAR(150) NULL DEFAULT NULL ,
  `cidade` VARCHAR(150) NULL DEFAULT NULL ,
  `uf` VARCHAR(2) NULL DEFAULT NULL ,
  `tel_fixo` VARCHAR(15) NULL ,
  `tel_celular` VARCHAR(15) NULL ,
  `pessoa_ref` VARCHAR(150) NULL DEFAULT NULL ,
  `tel_ref` VARCHAR(15) NULL DEFAULT NULL ,
  `plano_saude` VARCHAR(150) NULL DEFAULT NULL ,
  `atestado_medico` VARCHAR(50) NULL DEFAULT NULL ,
  `observacao` VARCHAR(200) NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_aluno`) ,
  INDEX `fk_aluno_1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_organizacao_aluno`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 491
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`aula`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`aula` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`aula` (
  `id_aula` INT(11) NOT NULL AUTO_INCREMENT ,
  `data` DATE NULL DEFAULT NULL ,
  `horario` VARCHAR(10) NULL DEFAULT NULL ,
  `excedente` INT(11) NOT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_aula`) ,
  INDEX `fk_aula_1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_organizacao_aula`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 339
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`alunos_aula`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`alunos_aula` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`alunos_aula` (
  `id_aluno_aula` INT(11) NOT NULL AUTO_INCREMENT ,
  `num_senha` INT(2) NOT NULL ,
  `id_aluno` INT(11) NOT NULL ,
  `id_aula` INT(11) NOT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_aluno_aula`) ,
  INDEX `id_aluno_fk` (`id_aluno` ASC) ,
  INDEX `id_aula_fk` (`id_aula` ASC) ,
  INDEX `fk_alunos_aula_1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_aluno_alunos_aula`
    FOREIGN KEY (`id_aluno` )
    REFERENCES `wodstorm`.`aluno` (`id_aluno` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_aula_alunos_aula`
    FOREIGN KEY (`id_aula` )
    REFERENCES `wodstorm`.`aula` (`id_aula` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_organizacao_alunos_aula`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3791
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `wodstorm`.`aulaexp`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`aulaexp` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`aulaexp` (
  `id_aulaexp` INT(11) NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(150) NULL DEFAULT NULL ,
  `data_aula` DATE NULL DEFAULT NULL ,
  `telefone` VARCHAR(13) NOT NULL ,
  `observacao` LONGTEXT NULL ,
  `confirmado` VARCHAR(50) NULL DEFAULT NULL ,
  `presente` VARCHAR(50) NULL DEFAULT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_aulaexp`) ,
  INDEX `fk_aulaexp_1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_organizacao_aulaexp`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 115
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`desconto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`desconto` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`desconto` (
  `id_desconto` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(150) NULL DEFAULT NULL ,
  `porc_desc` INT(11) NULL DEFAULT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_desconto`) ,
  INDEX `fk_desconto_1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_organizacao_desconto`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`estacionamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`estacionamento` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`estacionamento` (
  `id_estacionamento` INT(11) NOT NULL AUTO_INCREMENT ,
  `modelo` VARCHAR(150) NULL DEFAULT NULL ,
  `cor` VARCHAR(150) NULL DEFAULT NULL ,
  `placa` VARCHAR(8) NULL DEFAULT NULL ,
  `plano_ini` DATE NOT NULL ,
  `plano_fim` DATE NOT NULL ,
  `valor` DECIMAL(9,2) NOT NULL ,
  `estacionamento_status` VARCHAR(50) NOT NULL ,
  `observacao` VARCHAR(200) NULL DEFAULT NULL ,
  `id_aluno` INT(11) NOT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_estacionamento`) ,
  INDEX `fk_id_aluno_estacionamento` (`id_aluno` ASC) ,
  INDEX `fk_id_organizacao_estacionamento` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_aluno_estacionamento`
    FOREIGN KEY (`id_aluno` )
    REFERENCES `wodstorm`.`aluno` (`id_aluno` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_organizacao_estacionamento`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 143
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`forma_pagamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`forma_pagamento` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`forma_pagamento` (
  `id_forma_pagamento` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(150) NOT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_forma_pagamento`) ,
  INDEX `fk_forma_pagamento_1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_organizacao_forma_pagamento`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`plano`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`plano` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`plano` (
  `id_plano` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(150) NULL DEFAULT NULL ,
  `tipo` INT NULL DEFAULT NULL ,
  `valor` DECIMAL(9,2) NULL DEFAULT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_plano`) ,
  INDEX `fk_plano_1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_organizacao_plano`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 73
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(150) NOT NULL ,
  `usuario` VARCHAR(150) NOT NULL ,
  `senha` VARCHAR(150) NOT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_usuario`) ,
  INDEX `fk_usuario_1_idx` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_organizacao_usuario`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`contrato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`contrato` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`contrato` (
  `id_contrato` INT NOT NULL AUTO_INCREMENT ,
  `data_inicio` DATE NOT NULL ,
  `data_fim` DATE NOT NULL ,
  `horario_economico` VARCHAR(1) NOT NULL ,
  `status` VARCHAR(45) NOT NULL ,
  `dias_trancado` INT NULL ,
  `observacao` VARCHAR(200) NULL ,
  `id_aluno` INT NOT NULL ,
  `id_plano` INT NOT NULL ,
  `id_forma_pagamento` INT NOT NULL ,
  `id_desconto` INT NOT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_contrato`) ,
  INDEX `fk_contrato_1_idx` (`id_aluno` ASC) ,
  INDEX `fk_contrato_2_idx` (`id_plano` ASC) ,
  INDEX `fk_contrato_1_idx1` (`id_forma_pagamento` ASC) ,
  INDEX `fk_contrato_1_idx2` (`id_desconto` ASC) ,
  INDEX `fk_contrato_1_idx3` (`id_organizacao` ASC) ,
  CONSTRAINT `fk_id_aluno_contrato`
    FOREIGN KEY (`id_aluno` )
    REFERENCES `wodstorm`.`aluno` (`id_aluno` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_plano_contrato`
    FOREIGN KEY (`id_plano` )
    REFERENCES `wodstorm`.`plano` (`id_plano` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_forma_pagamento_contrato`
    FOREIGN KEY (`id_forma_pagamento` )
    REFERENCES `wodstorm`.`forma_pagamento` (`id_forma_pagamento` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_desconto_contrato`
    FOREIGN KEY (`id_desconto` )
    REFERENCES `wodstorm`.`desconto` (`id_desconto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_organizacao_contrato`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wodstorm`.`servico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wodstorm`.`servico` ;

CREATE  TABLE IF NOT EXISTS `wodstorm`.`servico` (
  `id_servico` INT NOT NULL AUTO_INCREMENT ,
  `tipo` VARCHAR(60) NOT NULL ,
  `valor` DECIMAL(9,2) NOT NULL ,
  `descricao` VARCHAR(200) NULL ,
  `id_aluno` INT NOT NULL ,
  `id_organizacao` INT NOT NULL ,
  PRIMARY KEY (`id_servico`) ,
  INDEX `fk_servico_1_idx` (`id_organizacao` ASC) ,
  INDEX `fk_servico_1_idx1` (`id_aluno` ASC) ,
  CONSTRAINT `fk_id_organizacao_servico`
    FOREIGN KEY (`id_organizacao` )
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_aluno_servico`
    FOREIGN KEY (`id_aluno` )
    REFERENCES `wodstorm`.`aluno` (`id_aluno` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

USE `wodstorm` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
