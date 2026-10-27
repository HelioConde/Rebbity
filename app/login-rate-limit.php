<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

/**
 * Basic server-side login throttling for the future isolated PHP deployment.
 * Uses an InnoDB table and hashes; never trusts X-Forwarded-For from a client.
 * This is not a substitute for perimeter WAF, monitoring or account recovery.
 */
function rb_limit_login(string $email): void
{
    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    foreach ([
        ['email:' . strtolower(trim($email)), 7],
        ['ip:' . $ip, 60],
    ] as [$identifier, $limit]) {
        $hash = hash('sha256', $identifier);
        try {
            // Atomic single-row upsert: concurrent requests cannot bypass the counter.
            $stmt = rb_db()->prepare(
                'INSERT INTO login_attempts (limiter_hash, attempts, reset_at) ' .
                'VALUES (?, 1, UTC_TIMESTAMP(6) + INTERVAL 15 MINUTE) ' .
                'ON DUPLICATE KEY UPDATE ' .
                'attempts = IF(reset_at <= UTC_TIMESTAMP(6), 1, attempts + 1), ' .
                'reset_at = IF(reset_at <= UTC_TIMESTAMP(6), UTC_TIMESTAMP(6) + INTERVAL 15 MINUTE, reset_at)'
            );
            $stmt->bind_param('s', $hash);
            $stmt->execute();

            $query = rb_db()->prepare('SELECT attempts FROM login_attempts WHERE limiter_hash = ?');
            $query->bind_param('s', $hash);
            $query->execute();
            $attempts = (int) ($query->get_result()->fetch_assoc()['attempts'] ?? 0);
            if ($attempts > $limit) {
                header('Retry-After: 900');
                rb_error(429, 'Muitas tentativas de acesso. Tente novamente mais tarde.');
            }
        } catch (mysqli_sql_exception $exception) {
            error_log('Rebbity login throttle storage unavailable: ' . $exception->getMessage());
            rb_error(503, 'Serviço temporariamente indisponível.');
        }
    }
}

function rb_reset_login_limit(string $email): void
{
    // Clear only the successful email bucket. Keep the IP-wide limit,
    // so one legitimate account cannot reset the IP limit of attackers.
    $hash = hash('sha256', 'email:' . strtolower(trim($email)));
    try {
        $stmt = rb_db()->prepare('DELETE FROM login_attempts WHERE limiter_hash = ?');
        $stmt->bind_param('s', $hash);
        $stmt->execute();
    } catch (mysqli_sql_exception $exception) {
        error_log('Rebbity login throttle reset failed: ' . $exception->getMessage());
        rb_error(503, 'Serviço temporariamente indisponível.');
    }
}
