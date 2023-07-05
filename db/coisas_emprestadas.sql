CREATE DATABASE coisas_emprestadas;

USE coisas_emprestadas;

CREATE TABLE tipo_usuarios (
    tipo INT NOT NULL,
    slug VARCHAR(100) NOT NULL,
    PRIMARY KEY (tipo)
);

CREATE TABLE usuarios(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    usuario CHAR(100) NOT NULL,
    senha CHAR(100) NOT NULL,
    tipo_usuario INT NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_TIPO_USUARIO FOREIGN KEY (tipo_usuario) REFERENCES tipo_usuarios(tipo)
);

CREATE TABLE categorias(
    id INT NOT NULL AUTO_INCREMENT,
    slug VARCHAR(100) NOT NULL,
    id_usuario INT NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT FK_USUARIO_CATEGORIA FOREIGN KEY(id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE produtos(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    id_categoria INT NOT NULL,
    id_usuario INT NOT NULL,
    is_emprestado INT NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    CONSTRAINT FK_CATEGORIA_PRODUTO FOREIGN KEY(id_categoria) REFERENCES categorias(id) ON DELETE CASCADE,
    CONSTRAINT FK_USUARIO_PRODUTO FOREIGN KEY(id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);


CREATE TABLE emprestimos(
    id INT NOT NULL AUTO_INCREMENT,
    id_produto INT NOT NULL,
    id_usuario INT NOT NULL,
    data_emprestimo DATE NOT NULL,
    data_devolucao DATE NULL,
    nome_destinatario VARCHAR(255) NOT NULL,
    email_destinatario VARCHAR(255) NOT NULL,
    status INT NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    CONSTRAINT FK_PRODUTO_EMPRESTIMO FOREIGN KEY(id_produto) REFERENCES produtos(id) ON DELETE CASCADE,
    CONSTRAINT FK_USUARIO_EMPRESTIMO FOREIGN KEY(id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

INSERT INTO tipo_usuarios VALUES (1, 'Administrador');
INSERT INTO tipo_usuarios VALUES (2, 'Comum');

INSERT INTO usuarios(nome, usuario, senha, tipo_usuario) VALUES('Administrador', 'admin', 'admin', 1);

