<?php
declare(strict_types=1);

// Validação de upload no servidor antes de armazenar imagem como data URL.
// Não confiar no nome/extensão ou no Content-Type informado pelo navegador.
function partner_uploaded_image(string $field): string {
    $file = $_FILES[$field] ?? null;
    if ($file === null || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ''; // Imagem opcional; coluna img da tabela é NOT NULL.
    }
    if (!is_array($file) || ($file['error'] ?? null) !== UPLOAD_ERR_OK ||
        !is_int($file['size'] ?? null) || $file['size'] <= 0 || $file['size'] > 2 * 1024 * 1024) {
        throw new InvalidArgumentException('Arquivo inválido ou maior que 2 MB.');
    }
    $tmp = $file['tmp_name'] ?? '';
    if (!is_string($tmp) || !is_uploaded_file($tmp)) {
        throw new InvalidArgumentException('Origem do arquivo inválida.');
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmp);
    if (!in_array($mime, ['image/png', 'image/jpeg', 'image/webp'], true)) {
        throw new InvalidArgumentException('Somente PNG, JPEG ou WebP são aceitos.');
    }
    $dimensions = @getimagesize($tmp);
    if (!is_array($dimensions) || $dimensions[0] < 1 || $dimensions[1] < 1 ||
        $dimensions[0] > 4096 || $dimensions[1] > 4096) {
        throw new InvalidArgumentException('Dimensões da imagem inválidas.');
    }
    $data = file_get_contents($tmp);
    if ($data === false) throw new InvalidArgumentException('Arquivo ilegível.');
    return 'data:' . $mime . ';base64,' . base64_encode($data);
}
