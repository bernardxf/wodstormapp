CREATE TABLE `agrupador_financeiro` (
  `id_agrupador` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `id_organizacao` int(11) NOT NULL,
  PRIMARY KEY (`id_agrupador`),
  KEY `fk_agrupador_financeiro_organizacao1_idx` (`id_organizacao`),
  CONSTRAINT `fk_agrupador_financeiro_organizacao1` FOREIGN KEY (`id_organizacao`) REFERENCES `organizacao` (`id_organizacao`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `financeiro` (
  `id_financeiro` int(11) NOT NULL AUTO_INCREMENT,
  `valor` float NOT NULL,
  `tipo` char(1) NOT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `data` date NOT NULL,
  `id_agrupador` int(11) NOT NULL,
  `id_organizacao` int(11) NOT NULL,
  PRIMARY KEY (`id_financeiro`),
  KEY `fk_financeiro_agrupador_financeiro1_idx` (`id_agrupador`),
  KEY `fk_financeiro_organizacao1_idx` (`id_organizacao`),
  CONSTRAINT `fk_financeiro_agrupador_financeiro1` FOREIGN KEY (`id_agrupador`) REFERENCES `agrupador_financeiro` (`id_agrupador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_financeiro_organizacao1` FOREIGN KEY (`id_organizacao`) REFERENCES `organizacao` (`id_organizacao`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;