ALTER TABLE alunos_aula DROP FOREIGN KEY fk_id_aula_alunos_aula;

ALTER TABLE alunos_aula
   ADD CONSTRAINT fk_id_aula_alunos_aula
   FOREIGN KEY (id_aula)
   REFERENCES aula (id_aula)
   ON DELETE CASCADE;

ALTER TABLE servico ADD data date NOT NULL AFTER valor;