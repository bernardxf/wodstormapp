CREATE TABLE IF NOT EXISTS `wodstorm`.`historico_contrato` (
  `id_historico_contrato` INT(11) NOT NULL AUTO_INCREMENT,
  `data` DATE NOT NULL,
  `status_contrato` CHAR NOT NULL,
  `id_aluno` INT(11) NOT NULL,
  `id_contrato` INT(11) NOT NULL,
  `id_organizacao` INT(11) NOT NULL,
  PRIMARY KEY (`id_historico_contrato`),
  INDEX `fk_historico_contrato_aluno_idx` (`id_aluno` ASC),
  INDEX `fk_historico_contrato_contrato_idx` (`id_contrato` ASC),
  INDEX `fk_historico_contrato_organizacao1_idx` (`id_organizacao` ASC),
  CONSTRAINT `fk_historico_contrato_aluno`
    FOREIGN KEY (`id_aluno`)
    REFERENCES `wodstorm`.`aluno` (`id_aluno`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_historico_contrato_contrato`
    FOREIGN KEY (`id_contrato`)
    REFERENCES `wodstorm`.`contrato` (`id_contrato`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_historico_contrato_organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `wodstorm`.`organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


insert into historico_contrato (data, status_contrato, id_aluno, id_contrato, id_organizacao) 
	select contrato.data_inicio, 'A', contrato.id_aluno, contrato.id_contrato, contrato.id_organizacao from contrato 
	join aluno on aluno.id_aluno = contrato.id_aluno 
	where contrato.status = 'F' and aluno.status = 'A';

insert into historico_contrato (data, status_contrato, id_aluno, id_contrato, id_organizacao) 
	select contrato.data_fim, 'F', contrato.id_aluno, contrato.id_contrato, contrato.id_organizacao from contrato 
	join aluno on aluno.id_aluno = contrato.id_aluno 
	where contrato.status = 'F' and aluno.status = 'A';

insert into historico_contrato (data, status_contrato, id_aluno, id_contrato, id_organizacao) 
	select contrato.data_inicio, 'A', contrato.id_aluno, contrato.id_contrato, contrato.id_organizacao from contrato 
	join aluno on aluno.id_aluno = contrato.id_aluno 
	where contrato.status in ('A', 'T') and aluno.status = 'A';

insert into historico_contrato (data, status_contrato, id_aluno, id_contrato, id_organizacao) 
	select curdate(), 'T', contrato.id_aluno, contrato.id_contrato, contrato.id_organizacao from contrato 
	join aluno on aluno.id_aluno = contrato.id_aluno 
	where contrato.status = 'T' and aluno.status = 'A';


