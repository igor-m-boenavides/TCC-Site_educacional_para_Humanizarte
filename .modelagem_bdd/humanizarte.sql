CREATE DATABASE humanizarte;

DROP DATABASE humanizarte;

USE humanizarte;

DROP TABLE IF EXISTS curso;
CREATE TABLE IF NOT EXISTS humanizarte.curso (
id INT NOT NULL,
PRIMARY KEY (id),
nome VARCHAR(200) NOT NULL,
descricao TEXT NOT NULL
);

DROP TABLE IF EXISTS aluno;
CREATE TABLE IF NOT EXISTS humanizarte.aluno (
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY (id),
nome VARCHAR(200) DEFAULT NULL,
email VARCHAR(200) DEFAULT NULL,
senha VARCHAR(200) DEFAULT NULL,
telefone VARCHAR(200) DEFAULT NULL,
curso_id INT,
FOREIGN KEY (curso_id)
REFERENCES curso (id)
);

SELECT * FROM humanizarte.curso;
SELECT * FROM humanizarte.aluno;








