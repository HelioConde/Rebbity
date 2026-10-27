<?php
declare(strict_types=1);
require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/login-rate-limit.php';
rb_require_post();
rb_require_csrf();
$email = trim((string) ($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !is_string($password)) {
    rb_redirect('./index.html?pag=acess&erro=credentials');
}
// Limita tentativas por identificador e IP com armazenamento no MySQL.
rb_limit_login($email);
$stmt = rb_db()->prepare('SELECT id, password, block FROM client WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
if (!$user || !password_verify($password, $user['password'])) {
    rb_redirect('./index.html?pag=acess&erro=credentials');
}
if ($user['block'] === 'true') {
    rb_redirect('./index.html?pag=acess&erro=analise');
}
rb_reset_login_limit($email);
rb_start_session();
session_regenerate_id(true);
$id = (int) $user['id'];
$token = bin2hex(random_bytes(32));
$update = rb_db()->prepare('UPDATE client SET token = ? WHERE id = ?');
$update->bind_param('si', $token, $id);
$update->execute();
$_SESSION['id'] = $id;
$_SESSION['token'] = $token;
$_SESSION['csrf'] = bin2hex(random_bytes(32));
rb_redirect('./portal/index.php');
