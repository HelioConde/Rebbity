<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

function rb_register_partner(string $type): void
{
    rb_require_post();
    rb_require_csrf();
    if (!in_array($type, ['restaurant', 'market'], true)) {
        rb_error(422, 'Tipo de parceiro inválido.');
    }

    $email = strtolower(rb_post_text('email', 100));
    $email2 = strtolower(rb_post_text('email2', 100));
    $password = rb_post_text('password', 200);
    $password2 = rb_post_text('password2', 200);
    $cnpj = preg_replace('/\D+/', '', rb_post_text('cnpj', 30));
    $cpf = preg_replace('/\D+/', '', rb_post_text('cpf', 30, false));
    $phone = rb_post_text('phone', 25);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email !== $email2) {
        rb_error(422, 'Confirme um e-mail válido.');
    }
    if ($password !== $password2 || strlen($password) < 10) {
        rb_error(422, 'As senhas devem coincidir e ter pelo menos 10 caracteres.');
    }
    if (strlen($cnpj) !== 14 || ($cpf !== '' && strlen($cpf) !== 11)) {
        rb_error(422, 'Documento inválido.');
    }

    $fields = [
        'name' => rb_post_text('name', 100),
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'phone' => $phone,
        'bank' => '', 'agency' => '', 'count' => '', 'digit' => '',
        'cep' => rb_post_text('cep', 25),
        'city' => rb_post_text('city', 100),
        'state' => rb_post_text('state', 35),
        'district' => rb_post_text('district', 100),
        'address' => rb_post_text('address', 150),
        'class' => rb_post_text('class', 30),
        'complement' => rb_post_text('complement', 100, false),
        'corporateName' => rb_post_text('corporateName', 120),
        'cnpj' => $cnpj,
        'porpName' => rb_post_text('porpName', 100, false),
        'cpf' => $cpf,
        'rg' => '',
        'typeTable' => $type,
        'block' => 'true',
        'token' => '0'
    ];
    $columns = array_keys($fields); // fixed server-side keys only
    $quoted = array_map(static fn($key) => '`' . $key . '`', $columns);
    $placeholders = implode(', ', array_fill(0, count($fields), '?'));
    $sql = 'INSERT INTO client (' . implode(', ', $quoted) . ') VALUES (' . $placeholders . ')';
    $values = array_values($fields);
    try {
        // Do not rely on duplicate checks in application code: DB indexes are authoritative.
        $stmt = rb_db()->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($values)), ...$values);
        $stmt->execute();
    } catch (mysqli_sql_exception $exception) {
        if ((int) $exception->getCode() === 1062) {
            rb_error(409, 'Já existe um cadastro com esse e-mail ou CNPJ.');
        }
        error_log('Rebbity registration error: ' . $exception->getMessage());
        rb_error(503, 'Não foi possível concluir o cadastro.');
    }
    rb_redirect('./index.html?pag=finish&cadastrado=success');
}
