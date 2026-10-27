<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
rb_require_post();
rb_require_csrf();
$partnerId = rb_require_partner();
$id = filter_var($_POST['editNameCategoryID'] ?? null, FILTER_VALIDATE_INT);
if (!$id) rb_error(422, 'Categoria inválida.');
$name = rb_post_text('editNameCategory', 100);
$stmt = rb_db()->prepare('UPDATE category SET name = ? WHERE id = ? AND id_client = ?');
$stmt->bind_param('sii', $name, $id, $partnerId);
$stmt->execute();
echo 'OK';
