<?php
include("config.php");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `client_restaurante` (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(200) NOT NULL,
    phone int NOT NULL,
    bank VARCHAR(30) NOT NULL,
    agency VARCHAR(30) NOT NULL,
    count int NOT NULL,
    digit int NOT NULL,
    cep int NOT NULL,
    city VARCHAR(25) NOT NULL,
    state VARCHAR(35) NOT NULL,
    district VARCHAR(35) NOT NULL,
    address VARCHAR(45) NOT NULL,
    complement VARCHAR(45) NOT NULL,
    corporateName varchar (45) not null NOT NULL,
    cnpj int NULL,
    cpf int NULL,
    rg int not null NOT NULL,
    token VARCHAR(100) NOT NULL
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `client_market` (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(200) NOT NULL,
    phone int NOT NULL,
    bank VARCHAR(30) NOT NULL,
    agency VARCHAR(30) NOT NULL,
    count int NOT NULL,
    digit int NOT NULL,
    cep int NOT NULL,
    city VARCHAR(25) NOT NULL,
    state VARCHAR(35) NOT NULL,
    district VARCHAR(35) NOT NULL,
    address VARCHAR(45) NOT NULL,
    complement VARCHAR(45) NOT NULL,
    corporateName varchar (45) not null NOT NULL,
    cnpj int NULL,
    cpf int NULL,
    rg int not null NOT NULL,
    token VARCHAR(100) NOT NULL
)");

?>