<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
rb_require_post();
rb_require_csrf();
$partnerId = rb_require_partner();
$stmt = rb_db()->prepare("SELECT id, name FROM category WHERE type = 'main' AND id_client = ? ORDER BY id");
$stmt->bind_param('i', $partnerId);
$stmt->execute();
$categories = $stmt->get_result();
$itemStmt = rb_db()->prepare('SELECT id, name, description, sale, img FROM item WHERE id_category = ? AND id_client = ? ORDER BY id');
if ($categories->num_rows === 0) {
    echo '<p class="rb-empty" role="status">Seu cardápio ainda não possui categorias. Crie uma para começar.</p>';
}
while ($row = $categories->fetch_assoc()) {
    $id = (int) $row['id'];
    $name = rb_h($row['name']);
    $arg = rb_js_arg($row['name']);
    echo '<section class="categoryBox" aria-label="Categoria ' . $name . '">';
    echo '<div class="categoryGroup borderButton">';
    echo '<h2 class="titleC"><button type="button" onclick="categoryName(' . $id . ', ' . $arg . ')">' . $name . '</button></h2>';
    echo '<div class="categoryMenuControl"><button type="button" onclick="categoryDel(' . $id . ', ' . $arg . ')">Remover categoria</button></div>';
    echo '</div>';
    $itemStmt->bind_param('ii', $id, $partnerId);
    $itemStmt->execute();
    $items = $itemStmt->get_result();
    while ($item = $items->fetch_assoc()) {
        $itemId = (int) $item['id'];
        $image = rb_safe_image($item['img']);
        echo '<div class="categoryGroup2 rb-category-item">';
        if ($image !== '') echo '<img width="56" height="56" loading="lazy" alt="" src="' . rb_h($image) . '">';
        echo '<div class="categoryItem"><strong>' . rb_h($item['name']) . '</strong><span>' .
            rb_h($item['description']) . '</span></div>';
        echo '<span>R$ ' . rb_h($item['sale']) . '</span>';
        echo '<button type="button" onclick="categoryDelItem(' . $itemId . ', ' .
            rb_js_arg($item['name']) . ')">Remover item</button>';
        echo '</div>';
    }
    echo '<div class="categoryGroup2 categoryGroup2Margin"><span class="categoryGroupButton">';
    echo '<button type="button" onclick="categoryItem(' . $id . ', ' . $arg .
        ')" class="categoryButtonItem">+ Adicionar item</button></span></div>';
    echo '</section>';
}
