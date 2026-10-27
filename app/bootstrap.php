<?php
declare(strict_types=1);

/**
 * Rebbity bootstrap: no credentials are stored in source control.
 * Never echo connection exceptions to the browser.
 */
ini_set('display_errors', '0');
ini_set('log_errors', '1');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header("Content-Security-Policy: frame-ancestors 'none'; base-uri 'self'; object-src 'none'; form-action 'self'");
header('Referrer-Policy: strict-origin-when-cross-origin');

function rb_db(): mysqli
{
    static $db = null;
    if ($db instanceof mysqli) {
        return $db;
    }
    $host = getenv('REBBITY_DB_HOST');
    $user = getenv('REBBITY_DB_USER');
    $pass = getenv('REBBITY_DB_PASSWORD');
    $name = getenv('REBBITY_DB_NAME');
    if ($host === false || $user === false || $pass === false || $name === false ||
        $host === '' || $user === '' || $name === '') {
        error_log('Rebbity: database environment is not configured');
        http_response_code(503);
        exit('Serviço temporariamente indisponível.');
    }
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db = new mysqli($host, $user, $pass, $name, (int) (getenv('REBBITY_DB_PORT') ?: 3306));
        $db->set_charset('utf8mb4');
        return $db;
    } catch (Throwable $exception) {
        error_log('Rebbity DB connection error: ' . $exception->getMessage());
        http_response_code(503);
        exit('Serviço temporariamente indisponível.');
    }
}

function rb_start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_name('rebbity_sid');
    session_set_cookie_params([
        'lifetime' => 0, 'path' => '/', 'secure' => $https,
        'httponly' => true, 'samesite' => 'Lax'
    ]);
    session_start();
}

function rb_h($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function rb_redirect(string $location): void
{
    header('Location: ' . $location, true, 303);
    exit;
}

function rb_error(int $status, string $message): void
{
    http_response_code($status);
    header('Content-Type: text/plain; charset=UTF-8');
    exit($message);
}

function rb_require_post(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        header('Allow: POST');
        rb_error(405, 'Método não permitido.');
    }
}

function rb_csrf_token(): string
{
    rb_start_session();
    if (!isset($_SESSION['csrf']) || !is_string($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function rb_require_csrf(): void
{
    rb_start_session();
    $given = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!is_string($given) || !hash_equals(rb_csrf_token(), $given)) {
        rb_error(403, 'Sessão expirada. Atualize a página e tente novamente.');
    }
}

function rb_partner(): array
{
    rb_start_session();
    $id = filter_var($_SESSION['id'] ?? null, FILTER_VALIDATE_INT);
    $token = $_SESSION['token'] ?? null;
    if (!$id || !is_string($token) || $token === '') {
        rb_error(401, 'Acesso não autenticado.');
    }
    try {
        $stmt = rb_db()->prepare('SELECT id, name, email, token, block FROM client WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $partner = $stmt->get_result()->fetch_assoc();
        if (!$partner || !is_string($partner['token']) ||
            !hash_equals($partner['token'], $token) ||
            $partner['block'] === 'true') {
            rb_error(403, 'Acesso não autorizado.');
        }
        return $partner;
    } catch (mysqli_sql_exception $exception) {
        error_log('Rebbity partner validation failed: ' . $exception->getMessage());
        rb_error(503, 'Serviço temporariamente indisponível.');
    }
}

function rb_require_partner(): int
{
    return (int) rb_partner()['id'];
}

function rb_post_text(string $field, int $max = 255, bool $required = true): string
{
    $value = $_POST[$field] ?? '';
    if (!is_string($value)) {
        rb_error(422, 'Campo inválido: ' . $field);
    }
    $value = trim($value);
    if (($required && $value === '') || mb_strlen($value, 'UTF-8') > $max) {
        rb_error(422, 'Campo inválido: ' . $field);
    }
    return $value;
}

function rb_upload_image(string $field): string
{
    if (!isset($_FILES[$field]) || (int) $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return '';
    }
    $file = $_FILES[$field];
    if (!is_array($file) || (int) ($file['error'] ?? -1) !== UPLOAD_ERR_OK ||
        (int) ($file['size'] ?? 0) < 1 || (int) ($file['size'] ?? 0) > 2 * 1024 * 1024 ||
        !is_uploaded_file((string) ($file['tmp_name'] ?? ''))) {
        rb_error(422, 'Imagem inválida ou maior que 2 MB.');
    }
    $path = (string) $file['tmp_name'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($path);
    if (!in_array($mime, ['image/png', 'image/jpeg', 'image/webp'], true)) {
        rb_error(422, 'Formato de imagem não permitido.');
    }
    $size = @getimagesize($path);
    if (!$size || $size[0] > 2400 || $size[1] > 2400) {
        rb_error(422, 'Dimensões da imagem não permitidas.');
    }
    $data = file_get_contents($path);
    if ($data === false) {
        rb_error(422, 'Não foi possível ler a imagem.');
    }
    return 'data:' . $mime . ';base64,' . base64_encode($data);
}

function rb_safe_image($value): string
{
    $src = (string) $value;
    return preg_match('~^data:image/(?:png|jpeg|webp);base64,[A-Za-z0-9+/=]+$~D', $src)
        ? $src : '';
}

function rb_js_arg($value): string
{
    return rb_h(json_encode((string) $value,
        JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR));
}

function rb_valid_cnpj(string $cnpj): bool
{
    if (!preg_match('/^[0-9]{14}$/D', $cnpj) || preg_match('/^([0-9])\\1{13}$/D', $cnpj)) {
        return false;
    }
    $digits = array_map('intval', str_split($cnpj));
    foreach ([[5,4,3,2,9,8,7,6,5,4,3,2], [6,5,4,3,2,9,8,7,6,5,4,3,2]] as $index => $weights) {
        $sum = 0;
        foreach ($weights as $i => $weight) $sum += $weight * $digits[$i];
        $mod = $sum % 11;
        $check = $mod < 2 ? 0 : 11 - $mod;
        if ($digits[12 + $index] !== $check) return false;
    }
    return true;
}
