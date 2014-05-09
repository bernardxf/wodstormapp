ALTER TABLE `wodstorm`.`contrato` 
ADD COLUMN `data_fim_computada` VARCHAR(45) NOT NULL AFTER `data_inicio`;

UPDATE contrato SET data_fim_computada = (SELECT data_fim FROM 
	 aluno WHERE contrato.id_aluno = aluno.id_aluno LIMIT 1);