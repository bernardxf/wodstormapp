-- CRIACAO DA TABELA DE PERMISSAO DE ACESSO (DEFINE AS PERMISSOES QUE CADA GRUPO DE USUARIOS DE CADA ORGANIZACAO POSSUI)
-- PARA OS ITENS DE CONTROLE_ACESSO (ATÉ O MOMENTO, OS MENUS).
CREATE TABLE IF NOT EXISTS `permissao_acesso` (
  `id_permissao_acesso` INT NOT NULL AUTO_INCREMENT,
  `id_controle_acesso` INT NOT NULL,
  `permissao` INT(11) NOT NULL,
  `id_organizacao` INT(11) NOT NULL,
  `id_grupo_usuario` INT(11) NOT NULL,
  PRIMARY KEY (`id_permissao_acesso`),
  INDEX `fk_permissao_acesso_controle_acesso1_idx` (`id_controle_acesso` ASC),
  INDEX `fk_permissao_acesso_organizacao1_idx` (`id_organizacao` ASC),
  INDEX `fk_permissao_acesso_grupo_usuario1_idx` (`id_grupo_usuario` ASC),
  CONSTRAINT `fk_permissao_acesso_controle_acesso1`
    FOREIGN KEY (`id_controle_acesso`)
    REFERENCES `controle_acesso` (`id_controle_acesso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permissao_acesso_organizacao1`
    FOREIGN KEY (`id_organizacao`)
    REFERENCES `organizacao` (`id_organizacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permissao_acesso_grupo_usuario1`
    FOREIGN KEY (`id_grupo_usuario`)
    REFERENCES `grupo_usuario` (`id_grupo_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- REMOCAO DOS CAMPOS "PERMISSAO" E "ID_GRUPO_USUARIO", QUE FORAM TRANSMITIDOS
-- PARA A TABELA DE PERMISSAO_ACESSO.
ALTER TABLE controle_acesso
 DROP COLUMN permissao;


-- INSERCAO DA ORGANIZACAO PADRAO (ID_ORGANIZACAO: 0; NOME: ORGANIZACAO_PADRAO).
-- ESTA NOVA ORGANIZACAO IRÁ CONTROLAR OS COMPONENTES QUE SERÃO ADOTADOS POR
-- TODO O SISTEMA (EX.: OS COMPONENTES DE CONTROLE DE ACESSO, QUE SERAO UTILIZADOS
-- POR TODAS AS EMPRESAS CADASTRADAS, POSSUIRAO O ID_ORGANIZACAO DA ORGANIZACAO 
-- PADRAO - 0).
DELIMITER $$
DROP PROCEDURE IF EXISTS INSERE_ORGANIZACAO_PADRAO $$

CREATE PROCEDURE INSERE_ORGANIZACAO_PADRAO ()
BEGIN
  DECLARE max_id INT(11);

  INSERT INTO organizacao(nome) VALUES ('ORGANIZACAO_PADRAO');
  SELECT MAX(id_organizacao) into max_id FROM organizacao;
  update organizacao set id_organizacao = 0 where id_organizacao = max_id;
END $$

DELIMITER ;

call INSERE_ORGANIZACAO_PADRAO();

DROP PROCEDURE IF EXISTS INSERE_ORGANIZACAO_PADRAO;
-- FIM INSERCAO DE ORGANIZACAO PADRAO

-- TRANSFERENCIA DOS GRUPOS DE USUARIOS PADRAO (ADMINISTRADORES E RECEPCIONISTAS)
-- E DOS CONTROLES DE ACESSO PARA A ORGANIZACAO PADRAO.
update grupo_usuario set id_organizacao = 0;
update controle_acesso set id_organizacao = 0;


-- INSERCAO DOS ITENS DE PERMISSAO DE ACESSO PARA CADA GRUPO DE USUARIO PADRAO DE CADA 
-- ORGANIZACAO. ESTE SCRIPT PODERÁ SER EXECUTADO SEMPRE QUE UMA NOVA ORGANIZACAO FOR
-- CADASTRADA NO SISTEMA.
-- IMPORTANTE NOTAR QUE ESTE SCRIPT DÁ PERMISSAO TOTAL PARA TODOS OS GRUPOS DE USUARIOS
-- PADRAO EM TODOS OS MENUS. A PARTIR DO MOMENTO QUE MENUS COM ACESSO CONTROLADO FOREM 
-- INCLUIDOS NO SISTEMA, ESTE SCRIPT DEVERÁ SER REVISTO.
insert into permissao_acesso (id_organizacao, id_controle_acesso, id_grupo_usuario, permissao)
select o.id_organizacao, ca.id_controle_acesso, gu.id_grupo_usuario, 2 permissao
  from controle_acesso ca, organizacao o, grupo_usuario gu
  where o.id_organizacao != 0
    and ca.id_organizacao = 0
    and gu.id_organizacao = 0
    and not exists (
    select 1
        from permissao_acesso pa
        where pa.id_organizacao     = o.id_organizacao 
          and pa.id_controle_acesso = ca.id_controle_acesso
          and pa.id_grupo_usuario   = gu.id_grupo_usuario
    );
