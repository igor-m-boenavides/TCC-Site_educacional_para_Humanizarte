CREATE DATABASE IF NOT EXISTS humanizarte;

USE humanizarte;

DROP TABLE IF EXISTS aluno;
CREATE TABLE IF NOT EXISTS aluno (
    id_aluno INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    telefone VARCHAR(45) NOT NULL,
    senha VARCHAR(45) NOT NULL,
    PRIMARY KEY (id_aluno)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS turma;
CREATE TABLE IF NOT EXISTS turma (
    id_turma INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    PRIMARY KEY (id_turma)
) ENGINE=InnoDB;

INSERT INTO turma (id_turma, nome) VALUES (1, 'Logos'), (2, 'Cronos'), (3, 'Sun Tzu');

DROP TABLE IF EXISTS aluno_turma;
CREATE TABLE IF NOT EXISTS aluno_turma (
    id_aluno_turma INT NOT NULL AUTO_INCREMENT,
    id_aluno INT NOT NULL,
    id_turma INT NOT NULL,
    PRIMARY KEY (id_aluno_turma),
    CONSTRAINT fk_aluno_has_turma_aluno1
        FOREIGN KEY (id_aluno)
        REFERENCES aluno (id_aluno)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_aluno_has_turma_turma1
        FOREIGN KEY (id_turma)
        REFERENCES turma (id_turma)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

DROP TABLE IF EXISTS aula;
CREATE TABLE IF NOT EXISTS aula (
    id_aula INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    url_video VARCHAR(200) NOT NULL,
    nome_video VARCHAR(200) NOT NULL,
    url_anexo VARCHAR(200) NOT NULL,
    nome_anexo VARCHAR(200) NOT NULL,
    descricao VARCHAR(500) NOT NULL,
    PRIMARY KEY (id_aula)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS aula_turma;
CREATE TABLE IF NOT EXISTS aula_turma (
    id_aula_turma INT NOT NULL AUTO_INCREMENT,
    id_aula INT NOT NULL,
    id_turma INT NOT NULL,
    PRIMARY KEY (id_aula_turma),
    CONSTRAINT fk_aula_has_turma_aula1
        FOREIGN KEY (id_aula)
        REFERENCES aula (id_aula)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_aula_has_turma_turma1
        FOREIGN KEY (id_turma)
        REFERENCES turma (id_turma)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;
