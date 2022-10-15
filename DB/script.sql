CREATE DATABASE IF NOT EXISTS DockerComposeGui;

USE DockerComposeGui;

CREATE TABLE IF NOT EXISTS users (
    id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(55) NOT NULL,
    apellido1 VARCHAR(55) NOT NULL,
    apellido2 VARCHAR(55) NOT NULL,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(55) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role int
);

INSERT IGNORE INTO users VALUES (1,'Administrador','WebminDocker','GUI','akaenterprises47@gmail.com','WebminDockerGuiAdmin','webmindockerguipassword',1);