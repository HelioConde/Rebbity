<?php
declare(strict_types=1);
require_once __DIR__ . '/app/bootstrap.php';
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    header('Allow: GET');
    rb_error(405, 'Método não permitido.');
}
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');
echo json_encode(['token' => rb_csrf_token()], JSON_THROW_ON_ERROR);
