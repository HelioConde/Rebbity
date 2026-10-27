<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
rb_require_post();
rb_require_csrf();
$id = rb_require_partner();
$name = rb_post_text('nameCategory', 100);
$kind = 'main';
$empty = '';
$stmt = rb_db()->prepare('INSERT INTO category (id_client, name, type, ranger, rangeMin, rangeMax) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('isssss', $id, $name, $kind, $empty, $empty, $empty);
$stmt->execute();
echo (string) rb_db()->insert_id;
