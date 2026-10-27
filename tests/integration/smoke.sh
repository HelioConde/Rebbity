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
echo 'OK: cadastro, aprovação e login seguro de duas contas'

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
assert_code 200 -c "$COOKIE_B" -b "$COOKIE_B" -X POST "$BASE/portal/categoryChageDel.php" \
  --data-urlencode "_csrf=$TOKEN_B" --data-urlencode "delNameCategoryID=$ID"

COUNT="$(mysql -N -h 127.0.0.1 -u root -p"${MYSQL_ROOT_PASSWORD}" "$REBBITY_DB_NAME" \
  -e "SELECT COUNT(*) FROM category WHERE id=$ID;")"
[[ "$COUNT" == '1' ]] || { echo 'Falha no isolamento dos parceiros' >&2; exit 1; }

assert_code 403 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/categoryChageDel.php" \
  --data-urlencode "delNameCategoryID=$ID"
assert_code 200 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/viewCategory.php" \
  --data-urlencode "_csrf=$TOKEN_A"

assert_code 303 -c "$COOKIE_A" -b "$COOKIE_A" -X POST "$BASE/portal/logout.php" \
  --data-urlencode "_csrf=$TOKEN_A"
assert_code 401 -c "$COOKIE_A" -b "$COOKIE_A" "$BASE/portal/index.php"

echo 'OK: criação de categoria/item, isolamento entre parceiros, CSRF e logout'
