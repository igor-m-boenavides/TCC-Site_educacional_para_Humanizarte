CREATE DATABASE IF NOT EXISTS humanizarte;

USE humanizarte;

DROP TABLE IF EXISTS turma;
CREATE TABLE IF NOT EXISTS turma (
    id INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    nome VARCHAR(200) NOT NULL,
    descricao TEXT NOT NULL
);

DROP TABLE IF EXISTS aluno;
CREATE TABLE IF NOT EXISTS aluno (
    id INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    nome VARCHAR(200) DEFAULT NULL,
    email VARCHAR(200) DEFAULT NULL,
    senha VARCHAR(200) DEFAULT NULL,
    telefone VARCHAR(200) DEFAULT NULL,
    turma_id INT,
    FOREIGN KEY (turma_id)
        REFERENCES turma (id)
);

DROP TABLE IF EXISTS aluno_turma;
CREATE TABLE IF NOT EXISTS aluno_turma (
    aluno_id INT,
    turma_id INT,
    FOREIGN KEY (aluno_id)
        REFERENCES aluno (id),
    FOREIGN KEY (turma_id)
        REFERENCES turma (id),
    INDEX fk_aluno_idx (aluno_id),
    INDEX fk_turma_idx (turma_id)
);

DROP TABLE IF EXISTS aula;
CREATE TABLE IF NOT EXISTS aula (
    id INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    nome VARCHAR(200) DEFAULT NULL,
    descricao TEXT DEFAULT NULL,
    video VARCHAR(200) DEFAULT NULL,
    anexo VARCHAR(200) DEFAULT NULL,
    turma_id INT,
    FOREIGN KEY (turma_id)
        REFERENCES turma (id)
);

SELECT * FROM turma;
SELECT * FROM aluno;
SELECT * FROM aula;
