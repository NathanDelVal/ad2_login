DROP DATABASE IF EXISTS ad2_login_nathan;

CREATE DATABASE ad2_login_nathan  DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;

use ad2_login_nathan;

CREATE TABLE users(
    id int PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    senha VARCHAR(200) NOT NULL,
    blocked BOOLEAN DEFAULT false,
    admin BOOLEAN DEFAULT false
);

insert into `users`(`nome`, `email`, `senha`, `admin`) VALUES 
('meu nome', 'meunom2@gmail.com', 'ratanabá', 0),
('admin', 'admin@gmail.com', 'admin123', 1)