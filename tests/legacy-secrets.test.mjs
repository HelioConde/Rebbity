import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'

const read = (name) => readFileSync(new URL('../' + name, import.meta.url), 'utf8')
test('config principal não inclui segredos nem cria esquema por requisição', () => {
  const source = read('config.php')
  for (const key of ['REBBITY_DB_HOST','REBBITY_DB_USER','REBBITY_DB_PASSWORD','REBBITY_DB_NAME']) {
    assert.ok(source.includes("getenv('" + key + "')"), key)
  }
  assert.match(source, /http_response_code\(503\)/)
  assert.doesNotMatch(source, /\$(?:user|pass|dbname)\s*=\s*['"][^'"]+['"]/)
  assert.doesNotMatch(source, /\bmysqli_query\s*\(/)
})
for (const name of ['config2.php','backupconfig.php','portal/config.php']) {
  test(name + ' delega para config.php, sem senha embutida', () => {
    const source = read(name)
    assert.match(source, /require_once/)
    assert.match(source, /config\.php/)
    assert.doesNotMatch(source, /mysqli_connect|mysqli_query|\$pass\s*=/)
  })
}
test('as alterações de categorias respeitam id_client', () => {
  for(const name of ['portal/categoryChageDel.php','portal/categoryChageName.php']) {
    const source=read(name)
    assert.match(source, /AND id_client = \?/)
    assert.match(source, /mysqli_stmt_bind_param/)
  }
})
