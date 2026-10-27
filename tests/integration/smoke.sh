#!/usr/bin/env bash
set -euo pipefail

BASE="http://127.0.0.1:8099"
COOKIE_A="$(mktemp)"
COOKIE_B="$(mktemp)"
LOG="$(mktemp)"
php -S 127.0.0.1:8099 -t . >"$LOG" 2>&1 &
SERVER_PID=$!
trap 'kill "$SERVER_PID" 2>/dev/null || true; rm -f "$COOKIE_A" "$COOKIE_B" "$LOG"' EXIT

for i in $(seq 1 25); do
  if curl -fsS "$BASE/csrf.php" >/dev/null 2>&1; then break; fi
  sleep 0.2
done

csrf() {
  curl -fsS -c "$1" -b "$1" "$BASE/csrf.php" |
    php -r '$data = json_decode(stream_get_contents(STDIN), true); echo $data["token"] ?? "";'
}
http_code() {
  curl -sS -o /dev/null -w '%{http_code}' "$@"
}
assert_code() {
  local expected="$1"
  shift
  local got
  got="$(http_code "$@")"
  if [[ "$got" != "$expected" ]]; then
    echo "Esperado HTTP $expected, recebido $got" >&2
    exit 1
  fi
}
assert_code 401 "$BASE/portal/index.php"
assert_code 401 "$BASE/portal/view/dashboard.php"
assert_code 405 "$BASE/portal/categoryChageDel.php"
assert_code 403 -X POST "$BASE/portal/categoryChageDel.php"
echo 'OK: proteção sem sessão, método inválido e CSRF'

register() {
  local cookie="$1" email="$2" cnpj="$3"
  local token
  token="$(csrf "$cookie")"
  assert_code 303 -c "$cookie" -b "$cookie" -X POST "$BASE/insert_restaurant.php" \
    --data-urlencode "_csrf=$token" \
    --data-urlencode "name=Loja teste" \
    --data-urlencode "email=$email" \
    --data-urlencode "email2=$email" \
    --data-urlencode "password=ExampleTest123!" \
    --data-urlencode "password2=ExampleTest123!" \
    --data-urlencode "phone=61999998888" \
    --data-urlencode "cep=70000000" \
    --data-urlencode "city=Brasilia" \
    --data-urlencode "state=DF" \
    --data-urlencode "district=Centro" \
    --data-urlencode "address=Rua teste" \
    --data-urlencode "number=123" \
    --data-urlencode "class=restaurante" \
    --data-urlencode "corporateName=Empresa teste" \
    --data-urlencode "cnpj=$cnpj" \
    --data-urlencode "porpName=Teste" \
    --data-urlencode "cpf=12345678901"
}
register "$COOKIE_A" 'a@example.test' '11222333000181'
register "$COOKIE_B" 'b@example.test' '11444777000161'
mysql -h 127.0.0.1 -u root -p"${MYSQL_ROOT_PASSWORD}" "$REBBITY_DB_NAME" -e   "UPDATE client SET block='false' WHERE email IN ('a@example.test', 'b@example.test');"

login() {
  local cookie="$1" email="$2"
  local token
  token="$(csrf "$cookie")"
  assert_code 303 -c "$cookie" -b "$cookie" -X POST "$BASE/authentication.php" \
    --data-urlencode "_csrf=$token" \
    --data-urlencode "email=$email" \
    --data-urlencode "password=ExampleTest123!"
  assert_code 200 -c "$cookie" -b "$cookie" "$BASE/portal/index.php"
}
login "$COOKIE_A" 'a@example.test'
login "$COOKIE_B" 'b@example.test'
assert_code 200 -c "$COOKIE_A" -b "$COOKIE_A" "$BASE/portal/view/dashboard.php"
# Rotas autenticadas acessadas diretamente também não devem ir ao cache.
for endpoint in portal/index.php portal/view/dashboard.php portal/view/category.php portal/view/menu.php; do
  HEADERS="$(curl -sS -D - -o /dev/null -c "$COOKIE_A" -b "$COOKIE_A" "$BASE/$endpoint")"
  if ! printf '%s\\n' "$HEADERS" | grep -Eiq '^Cache-Control:[^[:cntrl:]]*no-store'; then
    echo "Falta Cache-Control: no-store na rota $endpoint" >&2
    exit 1
  fi
  if ! printf '%s\\n' "$HEADERS" | grep -Eiq '^Pragma:[^[:cntrl:]]*no-cache'; then
    echo "Falta Pragma: no-cache na rota $endpoint" >&2
    exit 1
  fi
done
echo 'OK: respostas autenticadas diretas com política anti-cache'
echo 'OK: cadastro, aprovação e login seguro de duas contas'

# Rate limit: falhas sequenciais por e-mail devem bloquear ate senha correta.
# A regra mora no MySQL e nao pode ser ignorada ao trocar de cookie/sessao.
COOKIE_LIMIT="$(mktemp)"
trap 'kill "$SERVER_PID" 2>/dev/null || true; rm -f "$COOKIE_A" "$COOKIE_B" "$COOKIE_LIMIT" "$LOG"' EXIT
LIMIT_TOKEN="$(csrf "$COOKIE_LIMIT")"
for attempt in $(seq 1 7); do
  assert_code 303 -c "$COOKIE_LIMIT" -b "$COOKIE_LIMIT" -X POST "$BASE/authentication.php" \\
    --data-urlencode "_csrf=$LIMIT_TOKEN" --data-urlencode "email=a@example.test" \\
    --data-urlencode "password=senha-errada"
done
# A oitava tentativa deve receber HTTP 429 inclusive com senha correta.
assert_code 429 -c "$COOKIE_LIMIT" -b "$COOKIE_LIMIT" -X POST "$BASE/authentication.php" \\
  --data-urlencode "_csrf=$LIMIT_TOKEN" --data-urlencode "email=a@example.test" \\
  --data-urlencode "password=ExampleTest123!"
# Limite vinculado ao e-mail persistido no banco: outra sessao nao contorna.
LIMIT_TOKEN_B="$(csrf "$COOKIE_B")"
assert_code 429 -c "$COOKIE_B" -b "$COOKIE_B" -X POST "$BASE/authentication.php" \\
  --data-urlencode "_csrf=$LIMIT_TOKEN_B" --data-urlencode "email=a@example.test" \\
  --data-urlencode "password=ExampleTest123!"
# Simular expiracao da janela no banco de TESTES, sem aguardar 15 min.
mysql -h 127.0.0.1 -u root -p"${MYSQL_ROOT_PASSWORD}" "$REBBITY_DB_NAME" -e \\
  "UPDATE login_attempts SET reset_at = UTC_TIMESTAMP(6) - INTERVAL 1 SECOND"
assert_code 303 -c "$COOKIE_LIMIT" -b "$COOKIE_LIMIT" -X POST "$BASE/authentication.php" \\
  --data-urlencode "_csrf=$LIMIT_TOKEN" --data-urlencode "email=a@example.test" \\
  --data-urlencode "password=ExampleTest123!"
assert_code 200 -c "$COOKIE_LIMIT" -b "$COOKIE_LIMIT" "$BASE/portal/index.php"
echo 'OK: limitacao de tentativas, 429, troca de sessao e recuperacao apos expirar'

TOKEN_A="$(csrf "$COOKIE_A")"
ID="$(curl -fsS -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/insertCategory.php" \
  --data-urlencode "_csrf=$TOKEN_A" --data-urlencode "nameCategory=Promocoes")"
[[ "$ID" =~ ^[0-9]+$ ]] || { echo 'Falha ao criar categoria' >&2; exit 1; }

assert_code 200 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/insertItem.php" \
  --data-urlencode "_csrf=$TOKEN_A" \
  --data-urlencode "newItemCategoryIdMain=$ID" \
  --data-urlencode "newItemName=Teste" \
  --data-urlencode "newItemSale=9,99"

# Account B cannot insert into, change or delete account A's category.
TOKEN_B="$(csrf "$COOKIE_B")"
assert_code 403 -c "$COOKIE_B" -b "$COOKIE_B" -X POST "$BASE/portal/insertItem.php" \
  --data-urlencode "_csrf=$TOKEN_B" \
  --data-urlencode "newItemCategoryIdMain=$ID" \
  --data-urlencode "newItemName=Invasao" \
  --data-urlencode "newItemSale=0,00"
assert_code 404 -c "$COOKIE_B" -b "$COOKIE_B" -X POST "$BASE/portal/categoryChageDel.php" \
  --data-urlencode "_csrf=$TOKEN_B" --data-urlencode "delNameCategoryID=$ID"

COUNT="$(mysql -N -h 127.0.0.1 -u root -p"${MYSQL_ROOT_PASSWORD}" "$REBBITY_DB_NAME" \
  -e "SELECT COUNT(*) FROM category WHERE id=$ID;")"
[[ "$COUNT" == '1' ]] || { echo 'Falha no isolamento dos parceiros' >&2; exit 1; }

assert_code 403 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/categoryChageDel.php" \
  --data-urlencode "delNameCategoryID=$ID"
assert_code 200 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/viewCategory.php" \
  --data-urlencode "_csrf=$TOKEN_A"

# Segurança de regressão: SQL parametrizado, isolamento, XSS e upload.
assert_code 403 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/insertCategory.php" \
  --data-urlencode "_csrf=token-invalido" --data-urlencode "nameCategory=FalhaCSRF"
assert_code 422 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/insertCategory.php" \
  --data-urlencode "_csrf=$TOKEN_A" --data-urlencode "nameCategory="

# Uma categoria com caracteres HTML deve ser mostrada apenas como texto.
XSS_ID="$(curl -fsS -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/insertCategory.php" \
  --data-urlencode "_csrf=$TOKEN_A" \
  --data-urlencode 'nameCategory=<img src=x onerror=alert(1)>')"
[[ "$XSS_ID" =~ ^[0-9]+$ ]] || { echo "Falha ao criar categoria XSS de teste" >&2; exit 1; }
VIEW_A="$(curl -fsS -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/viewCategory.php" \
  --data-urlencode "_csrf=$TOKEN_A")"
printf '%s' "$VIEW_A" | grep -Fq '&lt;img src=x onerror=alert(1)&gt;' || {
  echo "Nome HTML não foi escapado na visão do parceiro" >&2; exit 1;
}
VIEW_B="$(curl -fsS -c "$COOKIE_B" -b "$COOKIE_B" -X POST "$BASE/portal/viewCategory.php" \
  --data-urlencode "_csrf=$TOKEN_B")"
if printf '%s' "$VIEW_B" | grep -Fq '&lt;img src=x onerror=alert(1)&gt;'; then
  echo "Visão do parceiro B vazou categoria do parceiro A" >&2; exit 1
fi

# POST sem vínculo de proprietário não pode alterar nome ou remover item.
assert_code 404 -c "$COOKIE_B" -b "$COOKIE_B" -X POST "$BASE/portal/categoryChageName.php" \
  --data-urlencode "_csrf=$TOKEN_B" --data-urlencode "editNameCategoryID=$ID" \
  --data-urlencode "editNameCategory=NomeInvadido"
CHANGED="$(mysql -N -h 127.0.0.1 -u root -p"${MYSQL_ROOT_PASSWORD}" "$REBBITY_DB_NAME" \
  -e "SELECT COUNT(*) FROM category WHERE id=$ID AND name='NomeInvadido';")"
[[ "$CHANGED" == '0' ]] || { echo "Escopo de categoria violado" >&2; exit 1; }

BAD_IMAGE="$(mktemp)"
printf 'não é uma imagem PNG' > "$BAD_IMAGE"
assert_code 422 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/insertItem.php" \
  -F "_csrf=$TOKEN_A" -F "newItemCategoryIdMain=$ID" \
  -F "newItemName=Imagem falsa" -F "newItemSale=9,99" \
  -F "imgInput=@$BAD_IMAGE;filename=fake.png;type=image/png"
rm -f "$BAD_IMAGE"
echo 'OK: CSRF, XSS, isolamento de categorias e MIME de uploads'

assert_code 303 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/logout.php" \
  --data-urlencode "_csrf=$TOKEN_A"
assert_code 401 -c "$COOKIE_A" -b "$COOKIE_A" "$BASE/portal/index.php"

echo 'OK: criação de categoria/item, isolamento entre parceiros, CSRF e logout'
