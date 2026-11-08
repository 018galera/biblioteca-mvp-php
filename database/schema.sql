CREATE DATABASE IF NOT EXISTS biblioteca_mvp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblioteca_mvp;

CREATE TABLE autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nacionalidade VARCHAR(50) NOT NULL
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    ano_publicacao INT NOT NULL,
    categoria_id INT NOT NULL,
    autor_id INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT,
    FOREIGN KEY (autor_id) REFERENCES autores(id) ON DELETE CASCADE
);

INSERT INTO categorias (nome) VALUES ('Ficção Científica'), ('Tecnologia'), ('Fantasia');
INSERT INTO autores (nome, nacionalidade) VALUES ('Frank Herbert', 'Americano'), ('Robert C. Martin', 'Americano'), ('J.R.R. Tolkien', 'Britânico');
INSERT INTO livros (titulo, ano_publicacao, categoria_id, autor_id) VALUES 
('Duna', 1965, 1, 1), 
('Clean Code', 2008, 2, 2),
('O Hobbit', 1937, 3, 3);