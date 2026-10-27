<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config.php';
require_once __DIR__ . '/auth-guard.php';
$partnerId = require_partner_session($conn);
$id = filter_var($_POST['delNameCategoryID'] ?? null, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);
if ($id === false) { http_response_code(422); exit('ID inválido.'); }
try {
    $stmt = mysqli_prepare($conn, "DELETE FROM category WHERE id = ? AND id_client = ? AND type = 'sub'");
    mysqli_stmt_bind_param($stmt, 'ii', $id, $partnerId);
    mysqli_stmt_execute($stmt);
    $changed = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    http_response_code($changed ? 204 : 404);
} catch (mysqli_sql_exception $exception) {
    error_log('Rebbity: falha ao remover subcategoria.');
    http_response_code(503);
    exit('Operação indisponível.');
}
