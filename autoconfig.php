<?php
include("config.php");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `client` (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(200) NOT NULL,
    phone VARCHAR(25) NOT NULL,
    bank VARCHAR(30) NOT NULL,
    agency VARCHAR(30) NOT NULL,
    count VARCHAR(25) NOT NULL,
    digit VARCHAR(25) NOT NULL,
    cep VARCHAR(25) NOT NULL,
    city VARCHAR(25) NOT NULL,
    state VARCHAR(35) NOT NULL,
    district VARCHAR(35) NOT NULL,
    address VARCHAR(45) NOT NULL,
    class VARCHAR(30) NOT NULL,
    complement VARCHAR(45) NOT NULL,
    corporateName varchar (45) NOT NULL,
    cnpj VARCHAR(30) NOT NULL,
    porpName VARCHAR(30) NOT NULL,
    cpf VARCHAR(25) NOT NULL,
    rg VARCHAR(25) not null NOT NULL,
    typeTable VARCHAR(30) NOT NULL,
    token VARCHAR(100) NOT NULL
)");

?>