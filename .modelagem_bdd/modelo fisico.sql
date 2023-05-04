CREATE DATABASE tcc_humanizarte;

USE tcc_humanizarte;

CREATE TABLE aluno (
    PRIMARY KEY (id),
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(50) NOT NULL,
    cpf VARCHAR(11) UNIQUE NOT NULL,
    telefone VARCHAR(50) NOT NULL,
    FOREIGN KEY (id)
        REFERENCES curso (id)
);

CREATE TABLE curso (
    PRIMARY KEY (id),
    id INT NOT NULL,
    nome VARCHAR(50) NOT NULL,
    qtd_alunos INT NOT NULL,
    preco DECIMAL(10 , 2 ) NOT NULL,
    FOREIGN KEY (id)
        REFERENCES aula (id)
);

CREATE TABLE aula (
    PRIMARY KEY (id),
    id INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL,
    descricao BLOB NOT NULL,
    video VARCHAR(100) NOT NULL,
    anexo VARCHAR(100) NOT NULL
);

CREATE TABLE professor (
    PRIMARY KEY (id),
    id INT NOT NULL,
    nome VARCHAR(50) NOT NULL,
    senha VARCHAR(50) NOT NULL,
    telefone VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    cpf VARCHAR(50) NOT NULL UNIQUE,
    id INT NOT NULL,
    FOREIGN KEY (id)
        REFERENCES curso (id)
);