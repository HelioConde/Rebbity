<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
$partner = rb_partner();
$id = (int) $partner['id'];
$db = rb_db();
$mainStmt = $db->prepare("SELECT COUNT(*) AS total FROM category WHERE id_client = ? AND type = 'main'");
$mainStmt->bind_param('i', $id);
$mainStmt->execute();
$categoryCount = (int) $mainStmt->get_result()->fetch_assoc()['total'];

$subStmt = $db->prepare("SELECT COUNT(*) AS total FROM category WHERE id_client = ? AND type = 'sub'");
$subStmt->bind_param('i', $id);
$subStmt->execute();
$complementCount = (int) $subStmt->get_result()->fetch_assoc()['total'];

$itemStmt = $db->prepare('SELECT COUNT(*) AS total FROM item WHERE id_client = ?');
$itemStmt->bind_param('i', $id);
$itemStmt->execute();
$itemCount = (int) $itemStmt->get_result()->fetch_assoc()['total'];
?>
<section class="rb-dashboard" aria-labelledby="rb-dashboard-title">
  <header class="rb-dashboard-header">
    <p class="rb-eyebrow">Portal de gestão</p>
    <h1 id="rb-dashboard-title">Bem-vindo, <?php echo rb_h($partner['name']); ?></h1>
    <p>Organize seu catálogo e encontre rapidamente o que precisa atualizar.</p>
  </header>

  <div class="rb-dashboard-metrics" aria-label="Resumo do catálogo">
    <article class="rb-dashboard-card"><p>Categorias</p>
      <strong><?php echo $categoryCount; ?></strong><span>categorias principais</span></article>
    <article class="rb-dashboard-card"><p>Itens cadastrados</p>
      <strong><?php echo $itemCount; ?></strong><span>produtos e complementos</span></article>
    <article class="rb-dashboard-card"><p>Complementos</p>
      <strong><?php echo $complementCount; ?></strong><span>grupos adicionais</span></article>
  </div>

  <div class="rb-dashboard-actions">
    <section>
      <h2>Seu próximo passo</h2>
      <p><?php echo $categoryCount === 0
        ? 'Comece criando a primeira categoria do seu cardápio.'
        : 'Revise seus itens e mantenha o catálogo organizado.'; ?></p>
      <a class="rb-btn rb-btn-primary" href="./index.php?pag=category">Gerenciar cardápio</a>
    </section>
    <section>
      <h2>Sobre este painel</h2>
      <p>O Rebbity está em modernização. Indicadores de vendas, pedidos e financeiro ainda não possuem dados operacionais validados.</p>
      <a class="rb-btn rb-btn-secondary" href="./index.php?pag=menu">Conhecer os cardápios</a>
    </section>
  </div>
</section>
