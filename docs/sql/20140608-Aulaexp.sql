ALTER TABLE aulaexp modify telefone VARCHAR(150);
ALTER TABLE aulaexp ADD COLUMN cpf VARCHAR(15) AFTER telefone;
ALTER TABLE aulaexp ADD COLUMN conhecendo VARCHAR(150) AFTER cpf;
ALTER TABLE aulaexp ADD COLUMN exp_crossfit VARCHAR(1) AFTER conhecendo;
ALTER TABLE aulaexp ADD COLUMN nota_aula VARCHAR(20) AFTER exp_crossfit;
ALTER TABLE aulaexp ADD COLUMN praticar VARCHAR(1) AFTER nota_aula;