CREATE DATABASE tcc_humanizarte;

USE tcc_humanizarte;

CREATE TABLE aluno (
    PRIMARY KEY (id_aluno),
    id_aluno INT NOT NULL AUTO_INCREMENT,
    nome_aluno VARCHAR(50) NOT NULL,
    email_aluno VARCHAR(50) NOT NULL UNIQUE,
    senha_aluno VARCHAR(50) NOT NULL,
    tipo_conta VARCHAR(10) NOT NULL,
    cpf_aluno VARCHAR(11) UNIQUE NOT NULL,
    telefone_aluno VARCHAR(50) NOT NULL,
    id_curso INT NOT NULL,
    FOREIGN KEY (id_curso)
        REFERENCES curso (id_curso)
);

CREATE TABLE curso (
    PRIMARY KEY (id_curso),
    id_curso INT NOT NULL,
    nome_curso VARCHAR(50) NOT NULL,
    qtd_alunos INT NOT NULL,
    preco_curso DECIMAL(10 , 2 ) NOT NULL
);

CREATE TABLE professor (
    PRIMARY KEY (id_professor),
    id_professor INT NOT NULL,
    nome_professor VARCHAR(50) NOT NULL,
    senha_professor VARCHAR(50) NOT NULL,
    telefone_professor VARCHAR(50) NOT NULL,
    email_professor VARCHAR(50) NOT NULL,
    cpf_professor VARCHAR(50) NOT NULL UNIQUE,
    id_curso INT NOT NULL,
    FOREIGN KEY (id_curso)
        REFERENCES curso (id_curso)
);