<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';
require_once __DIR__ . '/auth-guard.php';
$partnerId = require_partner_session($conn);
$name = trim((string) ($_POST['nameCategory'] ?? ''));
if ($name === '' || mb_strlen($name) > 100) {
    http_response_code(422);
    exit('Nome da categoria inválido.');
}

try {
    // A tabela legada possui colunas NOT NULL sem valores padrão.
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO category (id_client, name, type, ranger, rangeMin, rangeMax)
         VALUES (?, ?, 'main', '', '', '')"
    );
    mysqli_stmt_bind_param($stmt, 'is', $partnerId, $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('Location: ./index.html?pag=category', true, 303);
} catch (mysqli_sql_exception $exception) {
    error_log('Rebbity: erro ao adicionar categoria.');
    http_response_code(503);
    exit('Operação indisponível.');
}
