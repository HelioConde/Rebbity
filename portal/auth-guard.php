<?php
declare(strict_types=1);

// Controle compartilhado das rotas PHP que alteram dados do parceiro.
// Atenção: a migração CSRF das páginas antigas ainda é necessária.
function require_partner_session(mysqli $conn): int {
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
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $id = filter_var($_SESSION['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $token = $_SESSION['token'] ?? null;
    if ($id === false || !is_string($token) || strlen($token) < 32) {
        http_response_code(401);
        exit('Acesso não autorizado.');
    }

    $stmt = mysqli_prepare($conn, 'SELECT token, block FROM client WHERE id = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $member = mysqli_fetch_assoc($result) ?: null;
    mysqli_stmt_close($stmt);
    if (!$member || (string) ($member['block'] ?? '') === 'true' ||
        !hash_equals((string) $member['token'], $token)) {
        http_response_code(403);
        exit('Acesso não autorizado.');
    }
    return (int) $id;
}
