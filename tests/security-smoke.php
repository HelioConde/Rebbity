<?php
declare(strict_types=1);
// Checagens locais sem banco e sem exibir segredos reais.
$root = dirname(__DIR__);
$read = static function(string $path) use ($root): string {
    $content = file_get_contents($root . '/' . $path);
    if ($content === false) throw new RuntimeException('Arquivo ausente: ' . $path);
    return $content;
};
$config = $read('config.php');
if (!str_contains($config, "getenv('REBBITY_DB_USER')") ||
    !str_contains($config, "getenv('REBBITY_DB_PASSWORD')") ||
    str_contains($config, 'mysqli_query(')) {
    throw new RuntimeException('Conexão não isolada do esquema.');
}
foreach (['config2.php','backupconfig.php','portal/config.php'] as $path) {
    $contents = $read($path);
    if (str_contains($contents, 'mysqli_connect(') || str_contains($contents, '$pass =')) {
        throw new RuntimeException('Conexão duplicada no arquivo: ' . $path);
    }
}
foreach (['portal/categoryChageDel.php','portal/categoryChageName.php'] as $path) {
    $contents = $read($path);
    if (!str_contains($contents, 'AND id_client = ?') ||
        !str_contains($contents, 'mysqli_stmt_bind_param')) {
        throw new RuntimeException('Ausência de autorização de proprietário em ' . $path);
    }
}
$login = $read('authentication.php');
if (!str_contains($login, 'session_regenerate_id(true)') ||
    !str_contains($login, 'random_bytes(32)') ||
    !str_contains($login, 'mysqli_prepare')) {
    throw new RuntimeException('Autenticação ainda insegura.');
}
echo "PASS: conexão sem credenciais em fonte, autenticação e propriedade das categorias.\n";
