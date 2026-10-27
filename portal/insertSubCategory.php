<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
rb_require_post();
rb_require_csrf();
$partnerId = rb_require_partner();
$name = rb_post_text('editNameSubCategory', 100);
$range = rb_post_text('subCategoryRange', 20);
if (!in_array($range, ['optional', 'required'], true)) rb_error(422, 'Tipo de complemento inválido.');
$min = filter_var($_POST['subCategoryRange1'] ?? null, FILTER_VALIDATE_INT);
$max = filter_var($_POST['subCategoryRange2'] ?? null, FILTER_VALIDATE_INT);
if ($min === false || $max === false || $min < 0 || $max < $min || $max > 25) rb_error(422, 'Limites inválidos.');
$itemName = rb_post_text('itemName', 100);
$sale = rb_post_text('itemSale', 100);
$description = rb_post_text('Description', 100, false);
$pdv = rb_post_text('PVD', 100, false);
$image = rb_upload_image('imgInput2');
$kind = 'sub';
$minText = (string) $min;
$maxText = (string) $max;
$db = rb_db();
$db->begin_transaction();
try {
    $stmt = $db->prepare('INSERT INTO category (id_client, name, type, ranger, rangeMin, rangeMax) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('isssss', $partnerId, $name, $kind, $range, $minText, $maxText);
    $stmt->execute();
    $categoryId = (int) $db->insert_id;
    $empty = '';
    $stmt = $db->prepare('INSERT INTO item (id_client, id_category, name, sale, description, PDV, img, turn1, turn2, turn3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('iissssssss', $partnerId, $categoryId, $itemName, $sale, $description, $pdv, $image, $empty, $empty, $empty);
    $stmt->execute();
    $db->commit();
    echo (string) $categoryId;
} catch (Throwable $error) {
    $db->rollback();
    error_log('Subcategory insert failed: ' . $error->getMessage());
    rb_error(503, 'Erro ao cadastrar complemento.');
}
