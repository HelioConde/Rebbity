<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';
require_once __DIR__ . '/auth-guard.php';
$partnerId = require_partner_session($conn);

$id = filter_var($_POST['editNameCategoryID'] ?? null, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);
$name = trim((string) ($_POST['editNameCategory'] ?? ''));
if ($id === false || $name === '' || mb_strlen($name) > 100) {
    http_response_code(422);
    exit('Dados inválidos.');
}

try {
    $stmt = mysqli_prepare($conn, 'UPDATE category SET name = ? WHERE id = ? AND id_client = ?');
    mysqli_stmt_bind_param($stmt, 'sii', $name, $id, $partnerId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    http_response_code(204);
} catch (mysqli_sql_exception $exception) {
    error_log('Rebbity: erro ao renomear categoria.');
    http_response_code(503);
    exit('Operação indisponível.');
}
