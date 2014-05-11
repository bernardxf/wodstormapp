ALTER TABLE `wodstorm`.`contrato` 
ADD COLUMN `data_fim_computada` DATE NOT NULL DEFAULT '0000-00-00' AFTER `data_inicio`;

UPDATE contrato SET data_fim_computada = (SELECT data_fim FROM 
	 aluno WHERE contrato.id_aluno = aluno.id_aluno LIMIT 1);
