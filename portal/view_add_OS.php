<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
rb_require_post();
rb_require_csrf();
$partnerId = rb_require_partner();
$stmt = rb_db()->prepare("SELECT id, name FROM category WHERE type = 'sub' AND id_client = ? ORDER BY id");
$stmt->bind_param('i', $partnerId);
$stmt->execute();
$categories = $stmt->get_result();
$itemStmt = rb_db()->prepare('SELECT id, name, description, sale, img FROM item WHERE id_category = ? AND id_client = ? ORDER BY id');
echo '<div class="rb-complements">';
if ($categories->num_rows === 0) echo '<p role="status">Nenhum complemento cadastrado.</p>';
while ($cat = $categories->fetch_assoc()) {
    $id = (int) $cat['id'];
    echo '<section class="categoryBox"><div class="categoryGroupView borderButton">';
    echo '<h3 class="titleC">' . rb_h($cat['name']) . '</h3>';
    echo '<button type="button" onclick="categorySubDel(' . $id . ', ' .
        rb_js_arg($cat['name']) . ')">Remover complemento</button></div>';
    $itemStmt->bind_param('ii', $id, $partnerId);
    $itemStmt->execute();
    $items = $itemStmt->get_result();
    while ($item = $items->fetch_assoc()) {
        $src = rb_safe_image($item['img']);
        echo '<div class="categoryGroup2 rb-category-item">';
        if ($src !== '') echo '<img loading="lazy" width="56" height="56" src="' . rb_h($src) . '" alt="">';
        echo '<div class="categoryItem"><strong>' . rb_h($item['name']) . '</strong>';
        echo '<span>' . rb_h($item['description']) . '</span></div>';
        echo '<span>R$ ' . rb_h($item['sale']) . '</span>';
        echo '<button type="button" onclick="categoryDelItem(' . (int) $item['id'] . ', ' .
            rb_js_arg($item['name']) . ')">Remover item</button></div>';
    }
    echo '<div class="categoryGroup2"><button type="button" class="categoryButtonItem" onclick="addNewItemCategory(' .
        $id . ')">+ Adicionar item</button></div></section>';
}
echo '</div><div class="newCategoryButton"><button type="button" onclick="closeWindow2()">Cancelar</button></div>';
