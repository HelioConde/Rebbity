<?php
// Configuração legada: credenciais apenas via variáveis do provedor PHP.
// GitHub Pages não executa este arquivo nem fornece banco de dados.
$serve = getenv('REBBITY_DB_HOST') ?: 'localhost';
$user = getenv('REBBITY_DB_USER');
$pass = getenv('REBBITY_DB_PASSWORD');
$dbname = getenv('REBBITY_DB_NAME');

if (!$user || $pass === false || !$dbname) {
    error_log('Rebbity: variáveis de conexão não configuradas.');
    http_response_code(503);
    exit('Serviço temporariamente indisponível.');
}

    $conn = mysqli_connect($serve, $user, $pass, $dbname);
    if (!$conn) {
    error_log('Rebbity: falha na conexão com o banco.');
    http_response_code(503);
    exit('Serviço temporariamente indisponível.');
}
mysqli_set_charset($conn, 'utf8mb4');
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
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
            block VARCHAR(30) NOT NULL,
            token VARCHAR(100) NOT NULL
        )");

         mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `category` (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            id_client INT(6) NOT NULL,
            name VARCHAR(100) NOT NULL,
            type VARCHAR(100) NOT NULL,
            ranger VARCHAR(100) NOT NULL,
            rangeMin VARCHAR(100) NOT NULL,
            rangeMax VARCHAR(100) NOT NULL
        )");

        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `item` (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            id_client INT(6) NOT NULL,
            id_category INT(6) NOT NULL,
            name VARCHAR(100) NOT NULL,
            sale VARCHAR(100) NOT NULL,
            description VARCHAR(100) NOT NULL,
            PDV VARCHAR(100) NOT NULL,
            img longtext NOT NULL,
            turn1 VARCHAR(100) NOT NULL,
            turn2 VARCHAR(100) NOT NULL,
            turn3 VARCHAR(100) NOT NULL
        )");

    } 
?>