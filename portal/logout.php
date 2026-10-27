<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
rb_require_post();
rb_require_csrf();
$id = rb_require_partner();
$empty = '';
$stmt = rb_db()->prepare('UPDATE client SET token = ? WHERE id = ?');
$stmt->bind_param('si', $empty, $id);
$stmt->execute();
$_SESSION = [];
session_regenerate_id(true);
session_destroy();
rb_redirect('../index.html?pag=acess');
