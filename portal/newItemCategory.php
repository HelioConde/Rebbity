<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config.php';
require_once __DIR__ . '/auth-guard.php';
require_once __DIR__ . '/image-upload.php';
$partnerId = require_partner_session($conn);
$categoryId = filter_var($_POST['newItemCategoryId'] ?? null, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);
$name = trim((string) ($_POST['newItemCategoryName'] ?? ''));
$sale = trim((string) ($_POST['newItemCategorySale'] ?? ''));
$description = trim((string) ($_POST['newItemCategoryDescription'] ?? ''));
$pdv = trim((string) ($_POST['newItemCategoryPVD'] ?? ''));

if ($categoryId === false || $name === '' || mb_strlen($name) > 100 ||
    mb_strlen($sale) > 100 || mb_strlen($description) > 100 || mb_strlen($pdv) > 100) {
    http_response_code(422);
    exit('Dados inválidos.');
}
try {
    $image = partner_uploaded_image('imgInput2');
    $check = mysqli_prepare($conn, 'SELECT id FROM category WHERE id = ? AND id_client = ? LIMIT 1');
    mysqli_stmt_bind_param($check, 'ii', $categoryId, $partnerId);
    mysqli_stmt_execute($check);
    $found = mysqli_fetch_assoc(mysqli_stmt_get_result($check));
    mysqli_stmt_close($check);
    if (!$found) { http_response_code(404); exit('Categoria não encontrada.'); }

    $stmt = mysqli_prepare($conn, 'INSERT INTO item (id_client, id_category, name, sale, description, PDV, img) VALUES (?, ?, ?, ?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'iisssss', $partnerId, $categoryId, $name, $sale, $description, $pdv, $image);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    http_response_code(204);
} catch (InvalidArgumentException $exception) {
    http_response_code(422);
    exit($exception->getMessage());
} catch (mysqli_sql_exception $exception) {
    error_log('Rebbity: erro ao adicionar item.');
    http_response_code(503);
    exit('Operação indisponível.');
}
