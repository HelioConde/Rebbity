<?php
declare(strict_types=1);

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit;
}

ini_set('session.use_strict_mode', '1');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();
require_once __DIR__ . '/config.php';

// Mesmo aviso para e-mail inexistente e senha inválida: sem enumeração.
function invalid_credentials(): void {
    header('Location: index.html?pag=acess&erro=password', true, 303);
    exit;
}

$email = trim((string) ($_POST['email'] ?? ''));
$password = (string) ($_POST['password'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($email) > 254 || $password === '' || strlen($password) > 4096) {
    invalid_credentials();
}

try {
    $stmt = mysqli_prepare($conn, 'SELECT id, password, block FROM client WHERE email = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $member = mysqli_fetch_assoc($result) ?: null;
    mysqli_stmt_close($stmt);

    if (!$member || !password_verify($password, (string) $member['password'])) {
        invalid_credentials();
    }

    if ((string) $member['block'] === 'true') {
        header('Location: index.html?pag=acess&erro=analise', true, 303);
        exit;
    }

    // Nunca usar rand() ou mt_rand() para tokens de sessão.
    $token = bin2hex(random_bytes(32));
    $id = (int) $member['id'];
    $update = mysqli_prepare($conn, 'UPDATE client SET token = ? WHERE id = ?');
    mysqli_stmt_bind_param($update, 'si', $token, $id);
    mysqli_stmt_execute($update);
    mysqli_stmt_close($update);

    session_regenerate_id(true);
    $_SESSION['id'] = $id;
    $_SESSION['token'] = $token;
    header('Location: ./portal/index.html', true, 303);
    exit;
} catch (mysqli_sql_exception $exception) {
    error_log('Rebbity: falha ao processar autenticação.');
    http_response_code(503);
    exit('Serviço temporariamente indisponível.');
}
