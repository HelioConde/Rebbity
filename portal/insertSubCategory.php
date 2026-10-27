<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config.php';
require_once __DIR__ . '/auth-guard.php';
require_once __DIR__ . '/image-upload.php';
$partnerId = require_partner_session($conn);

$fields = [
    'categoryName' => trim((string) ($_POST['editNameSubCategory'] ?? '')),
    'name' => trim((string) ($_POST['itemName'] ?? '')),
    'range' => trim((string) ($_POST['subCategoryRange'] ?? '')),
    'min' => trim((string) ($_POST['subCategoryRange1'] ?? '')),
    'max' => trim((string) ($_POST['subCategoryRange2'] ?? '')),
    'sale' => trim((string) ($_POST['itemSale'] ?? '')),
    'description' => trim((string) ($_POST['Description'] ?? '')),
    'pdv' => trim((string) ($_POST['PVD'] ?? '')),
];
if ($fields['categoryName'] === '' || $fields['name'] === '') {
    http_response_code(422);
    exit('Categoria e item precisam de nome.');
}
foreach ($fields as $value) {
    if (mb_strlen($value) > 100) {
        http_response_code(422);
        exit('Campo muito longo.');
    }
}
try {
    $image = partner_uploaded_image('imgInput2');
    mysqli_begin_transaction($conn);
    $category = mysqli_prepare($conn,
        "INSERT INTO category (id_client, name, type, ranger, rangeMin, rangeMax) VALUES (?, ?, 'sub', ?, ?, ?)");
    mysqli_stmt_bind_param($category, 'issss', $partnerId, $fields['categoryName'], $fields['range'], $fields['min'], $fields['max']);
    mysqli_stmt_execute($category);
    mysqli_stmt_close($category);
    $id = (int) mysqli_insert_id($conn);

    $item = mysqli_prepare($conn,
        'INSERT INTO item (id_client, id_category, name, sale, description, PDV, img) VALUES (?, ?, ?, ?, ?, ?, ?)');
    mysqli_stmt_bind_param($item, 'iisssss', $partnerId, $id, $fields['name'], $fields['sale'], $fields['description'], $fields['pdv'], $image);
    mysqli_stmt_execute($item);
    mysqli_stmt_close($item);
    mysqli_commit($conn);
    header('Content-Type: text/plain; charset=utf-8');
    echo (string) $id;
} catch (InvalidArgumentException $exception) {
    http_response_code(422);
    exit($exception->getMessage());
} catch (mysqli_sql_exception $exception) {
    mysqli_rollback($conn);
    error_log('Rebbity: erro na criação da subcategoria e item.');
    http_response_code(503);
    exit('Operação indisponível.');
}
