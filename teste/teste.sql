CREATE DATABASE IF NOT EXISTS teste;

USE teste;

CREATE TABLE IF NOT EXISTS aluno (
    id_aluno INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    phone VARCHAR(45) NOT NULL,
    password VARCHAR(45) NOT NULL,
    PRIMARY KEY (id_aluno)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS turma (
    id_turma INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    PRIMARY KEY (id_turma)
) ENGINE=InnoDB;

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

INSERT INTO turma (id_turma, nome) VALUES (1, 'Logos'), (2, 'Cronos'), (3, 'Sun Tzu');
