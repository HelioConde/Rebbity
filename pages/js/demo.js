/* Rebbity: catálogo de demonstração, sem backend ou contas. */
(() => {
  const KEY = 'rebbity-demo-catalog-v2';
  const seed = () => ({
    categories: [
      { id: 'cat-refeicoes', name: 'Refeições' },
      { id: 'cat-bebidas', name: 'Bebidas' },
      { id: 'cat-sobremesas', name: 'Sobremesas' }
    ],
    products: [
      { id: 'prod-burger', categoryId: 'cat-refeicoes', name: 'Hambúrguer da casa', description: 'Pão, carne e molho especial', price: 28.9 },
      { id: 'prod-prato', categoryId: 'cat-refeicoes', name: 'Prato executivo', description: 'Arroz, feijão, salada e proteína', price: 32 },
      { id: 'prod-suco', categoryId: 'cat-bebidas', name: 'Suco natural', description: 'Copo de 300 ml', price: 9.5 },
      { id: 'prod-pudim', categoryId: 'cat-sobremesas', name: 'Pudim tradicional', description: 'Uma fatia', price: 12 }
    ]
  });
  const $ = id => document.getElementById(id);
  const formatMoney = value => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
  const make = (tag, className, content) => {
    const element = document.createElement(tag);
    if (className) element.className = className;
    if (content !== undefined) element.textContent = content;
    return element;
  };
  const clone = value => JSON.parse(JSON.stringify(value));
  const valid = input => input && Array.isArray(input.categories) && Array.isArray(input.products)
    && input.categories.every(c => typeof c.id === 'string' && typeof c.name === 'string')
    && input.products.every(p => typeof p.id === 'string' && typeof p.categoryId === 'string' &&
      typeof p.name === 'string' && typeof p.price === 'number' && Number.isFinite(p.price) &&
      typeof p.description === 'string');
  let state;
  try {
    const existing = localStorage.getItem(KEY);
    state = existing ? JSON.parse(existing) : seed();
    if (!valid(state)) state = seed();
  } catch { state = seed(); }
  const persist = () => {
    try { localStorage.setItem(KEY, JSON.stringify(state)); }
    catch { $('catalog-message').textContent = 'Não foi possível salvar neste navegador. A edição permanece disponível nesta sessão.'; }
  };
  persist();
  const newId = () => (crypto.randomUUID ? crypto.randomUUID() : 'id-' + Date.now() + '-' + Math.random().toString(36).slice(2));
  const currentCategory = () => $('filter-category').value;
  const collapsedCategories = new Set();
  const sortProducts = products => {
    const entries = [...products];
    const ordering = $('sort-products').value;
    if (ordering === 'name') entries.sort((a, b) => a.name.localeCompare(b.name, 'pt-BR'));
    if (ordering === 'price-asc') entries.sort((a, b) => a.price - b.price);
    if (ordering === 'price-desc') entries.sort((a, b) => b.price - a.price);
    return entries;
  };
  function render() {
    $('metric-categories').textContent = String(state.categories.length);
    $('metric-products').textContent = String(state.products.length);
    const total = state.products.reduce((sum, product) => sum + product.price, 0);
    $('metric-average').textContent = formatMoney(state.products.length ? total / state.products.length : 0);
    const selected = currentCategory();
    $('filter-category').replaceChildren(make('option', '', 'Todas'));
    $('filter-category').firstChild.value = '';
    for (const category of state.categories) {
      const option = make('option', '', category.name);
      option.value = category.id;
      $('filter-category').append(option);
    }
    $('filter-category').value = state.categories.some(category => category.id === selected) ? selected : '';
    const search = $('search-products').value.trim().toLocaleLowerCase('pt-BR');
    const filter = currentCategory();
    const list = $('catalog-list');
    list.replaceChildren();
    const allCollapsed = state.categories.length > 0 && state.categories.every(cat => collapsedCategories.has(cat.id));
    $('toggle-categories').textContent = allCollapsed ? 'Expandir todas' : 'Recolher todas';
    $('toggle-categories').setAttribute('aria-label', allCollapsed ? 'Expandir todas as categorias' : 'Recolher todas as categorias');
    if (state.categories.length === 0) {
      const empty = make('div', 'empty-state');
      empty.append(make('h3', '', 'Seu cardápio está vazio'), make('p', '', 'Crie uma categoria para começar.'));
      list.append(empty);
    } else {
      for (const category of state.categories) {
        if (filter && filter !== category.id) continue;
        const items = sortProducts(state.products.filter(p => p.categoryId === category.id &&
          (!search || (p.name + ' ' + p.description).toLocaleLowerCase('pt-BR').includes(search))));
        if (search && !items.length) continue;
        const section = make('section', 'category-block');
        const header = make('div', 'category-top');
        const left = make('div', 'category-label');
        const folded = collapsedCategories.has(category.id) && !search;
        left.append(make('h3', '', category.name), make('span', 'count-label', items.length + (items.length === 1 ? ' produto' : ' produtos')));
        const actions = make('div', 'category-actions');
        const add = make('button', 'small-btn add-item', '+ Produto');
        add.type = 'button'; add.dataset.action = 'add-item'; add.dataset.category = category.id;
        const edit = make('button', 'small-btn', 'Editar');
        edit.type = 'button'; edit.dataset.action = 'edit-category'; edit.dataset.category = category.id;
        const remove = make('button', 'small-btn danger', 'Excluir');
        remove.type = 'button'; remove.dataset.action = 'delete-category'; remove.dataset.category = category.id;
        const fold = make('button', 'small-btn fold-category', folded ? 'Expandir' : 'Recolher');
        fold.type = 'button'; fold.dataset.action = 'toggle-category'; fold.dataset.category = category.id;
        fold.setAttribute('aria-expanded', String(!folded));
        actions.append(fold, add, edit, remove); header.append(left, actions); section.append(header);
        const body = make('div', 'category-body');
        body.hidden = folded;
        if (!items.length) body.append(make('p', 'category-empty', 'Nenhum produto nesta categoria.'));
        for (const product of items) {
          const row = make('div', 'product-row');
          const info = make('div', 'product-info');
          info.append(make('strong', '', product.name), make('p', '', product.description || 'Sem descrição'));
          const price = make('strong', 'product-price', formatMoney(product.price));
          const controls = make('div', 'product-actions');
          const editItem = make('button', 'small-btn', 'Editar');
          editItem.type = 'button'; editItem.dataset.action = 'edit-product'; editItem.dataset.product = product.id;
          const deleteItem = make('button', 'small-btn danger', 'Excluir');
          deleteItem.type = 'button'; deleteItem.dataset.action = 'delete-product'; deleteItem.dataset.product = product.id;
          controls.append(editItem, deleteItem);
          row.append(info, price, controls); body.append(row);
        }
        section.append(body);
        list.append(section);
      }
      if (!list.children.length) list.append(make('p', 'empty-state', 'Nenhum produto encontrado para esta busca.'));
    }
    $('catalog-message').textContent = state.categories.length + ' categorias e ' + state.products.length + ' produtos no catálogo.';
  }
  const dialog = $('editor-dialog');
  const form = $('editor-form');
  let mode = null, activeId = null, parentId = null;
  function openEditor(nextMode, id = null, categoryId = null) {
    mode = nextMode; activeId = id; parentId = categoryId;
    const isProduct = mode === 'product';
    const existing = isProduct ? state.products.find(p => p.id === id) : state.categories.find(c => c.id === id);
    $('editor-title').textContent = (existing ? 'Editar ' : 'Nova ') + (isProduct ? 'produto' : 'categoria');
    $('editor-description').textContent = isProduct ? 'Defina o nome, a descrição e o preço.' : 'Dê um nome claro à seção do seu cardápio.';
    $('description-label').hidden = !isProduct;
    $('price-label').hidden = !isProduct;
    $('entry-name').value = existing?.name || '';
    $('entry-description').value = isProduct && existing ? existing.description : '';
    $('entry-price').value = isProduct && existing ? existing.price.toFixed(2) : '';
    $('editor-error').hidden = true;
    dialog.showModal();
    $('entry-name').focus();
  }
  $('add-category').addEventListener('click', () => openEditor('category'));
  $('close-dialog').addEventListener('click', () => dialog.close());
  $('cancel-edit').addEventListener('click', () => dialog.close());
  form.addEventListener('submit', event => {
    event.preventDefault();
    const name = $('entry-name').value.trim();
    if (!name || name.length > 90) {
      $('editor-error').textContent = 'Informe um nome de até 90 caracteres.';
      $('editor-error').hidden = false; $('entry-name').focus(); return;
    }
    if (mode === 'product') {
      const priceString = $('entry-price').value;
      const price = Number(priceString);
      if (!priceString || !Number.isFinite(price) || price < 0 || price > 999999) {
        $('editor-error').textContent = 'Informe um preço válido (zero ou maior).';
        $('editor-error').hidden = false; $('entry-price').focus(); return;
      }
      const product = state.products.find(p => p.id === activeId);
      if (product) { product.name = name; product.price = price; product.description = $('entry-description').value.trim(); }
      else state.products.push({ id: newId(), categoryId: parentId, name, description: $('entry-description').value.trim(), price });
    } else {
      const category = state.categories.find(c => c.id === activeId);
      if (category) category.name = name;
      else state.categories.push({ id: newId(), name });
    }
    persist(); dialog.close(); render();
  });
  $('catalog-list').addEventListener('click', event => {
    const target = event.target.closest('button[data-action]');
    if (!target) return;
    const { action, category, product } = target.dataset;
    if (action === 'toggle-category') {
      if (collapsedCategories.has(category)) collapsedCategories.delete(category);
      else collapsedCategories.add(category);
      render();
      const next = [...$('catalog-list').querySelectorAll('.fold-category')].find(el => el.dataset.category === category);
      next?.focus();
    }
    if (action === 'add-item') openEditor('product', null, category);
    if (action === 'edit-category') openEditor('category', category);
    if (action === 'edit-product') openEditor('product', product);
    if (action === 'delete-category') {
      const selected = state.categories.find(c => c.id === category);
      if (selected && confirm('Excluir a categoria "' + selected.name + '" e todos os produtos dela?')) {
        state.categories = state.categories.filter(c => c.id !== category);
        state.products = state.products.filter(p => p.categoryId !== category);
        persist(); render();
      }
    }
    if (action === 'delete-product') {
      const selected = state.products.find(p => p.id === product);
      if (selected && confirm('Excluir o produto "' + selected.name + '"?')) {
        state.products = state.products.filter(p => p.id !== product);
        persist(); render();
      }
    }
  });
  $('filter-category').addEventListener('change', render);
  $('sort-products').addEventListener('change', render);
  $('search-products').addEventListener('input', render);
  $('toggle-categories').addEventListener('click', () => {
    const allCollapsed = state.categories.length > 0 && state.categories.every(cat => collapsedCategories.has(cat.id));
    collapsedCategories.clear();
    if (!allCollapsed) state.categories.forEach(cat => collapsedCategories.add(cat.id));
    render();
  });
  $('reset-data').addEventListener('click', () => {
    if (confirm('Restaurar todos os exemplos? Suas edições atuais serão substituídas.')) {
      state = seed(); collapsedCategories.clear(); $('search-products').value = ''; $('filter-category').value = ''; $('sort-products').value = 'default';
      persist(); render();
    }
  });
  $('export-data').addEventListener('click', () => {
    const blob = new Blob([JSON.stringify(clone(state), null, 2)], { type: 'application/json;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const anchor = make('a'); anchor.href = url; anchor.download = 'rebbity-cardapio-demo.json';
    document.body.append(anchor); anchor.click(); anchor.remove();
    setTimeout(() => URL.revokeObjectURL(url), 1000);
  });
  const previewDialog = $('preview-dialog');
  const previewList = $('preview-list');
  const renderPreview = () => {
    previewList.replaceChildren();
    let count = 0;
    for (const category of state.categories) {
      const products = state.products.filter(item => item.categoryId === category.id);
      if (!products.length) continue;
      count += products.length;
      const group = make('section', 'preview-category');
      group.append(make('h3', '', category.name));
      const cards = make('div', 'preview-items');
      for (const product of products) {
        const card = make('article', 'preview-item');
        const content = make('div', 'preview-item-info');
        content.append(make('strong', '', product.name));
        if (product.description) content.append(make('p', '', product.description));
        card.append(content, make('span', 'preview-price', formatMoney(product.price)));
        cards.append(card);
      }
      group.append(cards);
      previewList.append(group);
    }
    if (count === 0) previewList.append(make('p', 'empty-state', 'Adicione produtos para visualizar o cardápio.'));
  };
  const openPreview = () => { renderPreview(); previewDialog.showModal(); };
  $('preview-catalog').addEventListener('click', openPreview);
  $('preview-aside').addEventListener('click', openPreview);
  $('close-preview').addEventListener('click', () => previewDialog.close());
  $('close-preview-bottom').addEventListener('click', () => previewDialog.close());
  const tipo = new URLSearchParams(location.search).get('tipo');
  if (tipo === 'mercado' && !localStorage.getItem('rebbity-demo-catalog-v2-market-shown')) {
    $('catalog-message').textContent = 'Você pode renomear as categorias para adaptar o catálogo a um mercado.';
    try { localStorage.setItem('rebbity-demo-catalog-v2-market-shown', '1'); } catch {}
  }
  render();
})();