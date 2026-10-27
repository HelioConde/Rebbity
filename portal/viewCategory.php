<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config.php';
require_once __DIR__ . '/auth-guard.php';
$partnerId = require_partner_session($conn, true);

try {
    $stmt = mysqli_prepare($conn, "SELECT id, name FROM category WHERE type = 'main' AND id_client = ? ORDER BY id");
    mysqli_stmt_bind_param($stmt, 'i', $partnerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = (int) $row['id'];
        $name = (string) $row['name'];
        $safeLabel = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $jsName = json_encode($name, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_INVALID_UTF8_SUBSTITUTE);
        $safeArg = htmlspecialchars($jsName === false ? '""' : $jsName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        ?>
        <div class="categoryBox">
          <div class="categoryGroup borderButton">
            <h1 class="titleC" onmouseup="categoryName(<?= $id ?>, <?= $safeArg ?>)"><?= $safeLabel ?></h1>
            <div class="categoryControl">
              <div><button class="categoryDisabled categoryButton categoryButton1">Pausar</button></div>
              <div><button class="categoryActive categoryButton categoryButton2">Ativar</button></div>
            </div>
            <div class="categoryMenuControl">
              <span class="angle-down"></span>
              <span class="categoryMenuControlHover">
                <span class="bars-staggered"></span>
                <span class="subMainMenu2">
                  <div onmouseup="categoryDelItem(<?= $id ?>, <?= $safeArg ?>)">Remover</div>
                </span>
              </span>
            </div>
          </div>
          <div class="categoryGroup2 categoryGroup2Margin">
            <span class="categoryGroupButton">
              <button onmouseup="categoryItem(<?= $id ?>, <?= $safeArg ?>)" class="categoryButtonItem">
                <span class="plus"></span><span>Adicionar item</span>
              </button>
            </span>
          </div>
        </div>
        <?php
    }
    mysqli_stmt_close($stmt);
} catch (mysqli_sql_exception $exception) {
    error_log('Rebbity: erro ao listar categorias.');
    http_response_code(503);
    exit('Operação indisponível.');
}
