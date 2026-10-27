import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
for (const name of ['config.php', 'config2.php', 'backupconfig.php']) {
  test(name + ' usa variáveis e falha com segurança', () => {
    const content = readFileSync(new URL('../'+name, import.meta.url), 'utf8')
    assert.match(content, /getenv\('REBBITY_DB_USER'\)/)
    assert.match(content, /getenv\('REBBITY_DB_PASSWORD'\)/)
    assert.match(content, /http_response_code\(503\)/)
    assert.doesNotMatch(content, /\$(?:user|pass)\s*=\s*['"][^'"]+['"]/)
    assert.doesNotMatch(content, /FTP\s+[A-Za-z0-9!@#$%^&*]{6,}/i)
  })
}
