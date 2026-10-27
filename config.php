<?php
declare(strict_types=1);

// Configuração exclusiva do servidor PHP. Não use dados do banco no GitHub Pages.
// As variáveis REBBITY_DB_* devem ser definidas no ambiente do provedor.
$serve = getenv('REBBITY_DB_HOST') ?: 'localhost';
$user = getenv('REBBITY_DB_USER');
$pass = getenv('REBBITY_DB_PASS');
$dbname = getenv('REBBITY_DB_NAME');

if (!is_string($user) || $user === '' || $pass === false ||
    !is_string($dbname) || $dbname === '') {
    error_log('Rebbity: conexão indisponível por falta de configuração.');
    http_response_code(503);
    exit('Serviço temporariamente indisponível.');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = mysqli_connect($serve, $user, (string) $pass, $dbname);
    mysqli_set_charset($conn, 'utf8mb4');
} catch (mysqli_sql_exception $exception) {
    error_log('Rebbity: falha de conexão com o banco.');
    http_response_code(503);
    exit('Serviço temporariamente indisponível.');
}

// NUNCA executar DDL (CREATE TABLE) em cada requisição HTTP.
// O esquema deve ser aplicado por migração administrativa, com backup.
