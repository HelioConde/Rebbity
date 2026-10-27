<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
rb_require_post();
rb_require_csrf();
$partnerId = rb_require_partner();
$id = filter_var($_POST['delNameCategoryID'] ?? null, FILTER_VALIDATE_INT);
if (!$id) rb_error(422, 'Item inválido.');
$stmt = rb_db()->prepare('DELETE FROM item WHERE id = ? AND id_client = ?');
$stmt->bind_param('ii', $id, $partnerId);
$stmt->execute();
echo 'OK';
