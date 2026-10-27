<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
rb_require_post();
rb_require_csrf();
$partnerId = rb_require_partner();
$id = filter_var($_POST['delNameCategoryID'] ?? null, FILTER_VALIDATE_INT);
if (!$id) rb_error(422, 'Categoria inválida.');
$db = rb_db();
$check = $db->prepare("SELECT id FROM category WHERE id = ? AND id_client = ? AND type = 'sub' LIMIT 1");
$check->bind_param('ii', $id, $partnerId);
$check->execute();
if (!$check->get_result()->fetch_assoc()) rb_error(403, 'Complemento não autorizado.');
$db->begin_transaction();
try {
    $stmt = $db->prepare('DELETE FROM item WHERE id_category = ? AND id_client = ?');
    $stmt->bind_param('ii', $id, $partnerId);
    $stmt->execute();
    $stmt = $db->prepare("DELETE FROM category WHERE id = ? AND id_client = ? AND type = 'sub'");
    $stmt->bind_param('ii', $id, $partnerId);
    $stmt->execute();
    $db->commit();
} catch (Throwable $error) {
    $db->rollback();
    error_log('Subcategory delete failed: ' . $error->getMessage());
    rb_error(503, 'Erro ao remover complemento.');
}
echo 'OK';
