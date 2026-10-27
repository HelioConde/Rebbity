import { test, expect } from '@playwright/test';
import { mkdir } from 'node:fs/promises';

test('home, navigation and accessibility keyboard menu', async ({ page }, info) => {
  const errors = [];
  page.on('pageerror', error => errors.push(error.message));
  await page.goto('/index.html');
  await expect(page.getByRole('heading', { name: /Organizar sua loja/i })).toBeVisible();
  await expect(page.locator('.actions a[href="./demo.html"]')).toBeVisible();
  const overflow = await page.evaluate(() => document.documentElement.scrollWidth > window.innerWidth + 2);
  expect(overflow).toBe(false);
  if (info.project.name === '320px' || info.project.name === '375px') {
    const toggle = page.locator('.nav-toggle');
    await toggle.click();
    await expect(toggle).toHaveAttribute('aria-expanded', 'true');
    await page.keyboard.press('Escape');
    await expect(toggle).toHaveAttribute('aria-expanded', 'false');
  }
  await mkdir('artifacts/pages-screenshots', {recursive: true});
  await page.screenshot({path: 'artifacts/pages-screenshots/' + info.project.name + '-home.png',fullPage: true,animations:'disabled'});
  expect(errors).toEqual([]);
});

test('demo CRUD, search, persistence and export', async ({ page }, info) => {
  const errors = [];
  page.on('pageerror', error => errors.push(error.message));
  await page.goto('/demo.html');
  await expect(page.getByRole('heading', { name: 'Meu cardápio' })).toBeVisible();
  await expect(page.locator('#metric-categories')).toHaveText('3');
  await page.getByRole('button', { name: '+ Categoria' }).click();
  await expect(page.getByRole('dialog')).toBeVisible();
  await page.locator('#entry-name').fill('Teste Playwright');
  await page.getByRole('button', {name: 'Salvar'}).click();
  await expect(page.locator('#catalog-list')).toContainText('Teste Playwright');
  const category = page.locator('.category-block').filter({has: page.getByRole('heading',{name:'Teste Playwright'})});
  await category.getByRole('button', {name: '+ Produto'}).click();
  await page.locator('#entry-name').fill('Suco de teste');
  await page.locator('#entry-description').fill('Descrição exemplo');
  await page.locator('#entry-price').fill('6.50');
  await page.getByRole('button', {name: 'Salvar'}).click();
  await expect(category).toContainText('Suco de teste');
  await expect(category).toContainText('R$ 6,50');
  await page.reload();
  await expect(page.locator('#catalog-list')).toContainText('Suco de teste');
  await page.locator('#search-products').fill('Suco de teste');
  await expect(page.locator('.product-row')).toHaveCount(1);
  const downloadPromise = page.waitForEvent('download');
  await page.getByRole('button',{name:'Exportar JSON'}).click();
  const download = await downloadPromise;
  expect(download.suggestedFilename()).toBe('rebbity-cardapio-demo.json');
  const overflow = await page.evaluate(() => document.documentElement.scrollWidth > window.innerWidth + 2);
  expect(overflow).toBe(false);
  await mkdir('artifacts/pages-screenshots', {recursive: true});
  await page.screenshot({path:'artifacts/pages-screenshots/'+info.project.name+'-demo.png',fullPage:true,animations:'disabled'});
  expect(errors).toEqual([]);
});

test('Pages bundle has no exposed PHP endpoints or personal data collection forms', async ({page}) => {
  await page.goto('/sobre.html');
  await expect(page.getByText(/não são executadas/i)).toBeVisible();
  const hasPhp = await page.locator('form[action$=".php"],a[href$=".php"]').count();
  expect(hasPhp).toBe(0);
});


test('compactar categorias, ordenar preços e visualizar como cliente', async ({ page }, info) => {
  const errors = [];
  page.on('pageerror', error => errors.push(error.message));
  await page.goto('/demo.html');
  await expect(page.locator('.category-block')).toHaveCount(3);
  await page.getByRole('button', { name: 'Recolher todas' }).click();
  await expect(page.locator('.category-body').first()).toBeHidden();
  await page.getByRole('button', { name: 'Expandir todas' }).click();
  await expect(page.locator('.category-body').first()).toBeVisible();
  await page.locator('#sort-products').selectOption('price-desc');
  const firstMeal = page.locator('.category-block').first().locator('.product-info strong').first();
  await expect(firstMeal).toHaveText('Prato executivo');
  await page.getByRole('button', { name: 'Visualizar cardápio' }).click();
  const preview = page.locator('#preview-dialog');
  await expect(preview).toBeVisible();
  await expect(preview).toContainText('Hambúrguer da casa');
  await expect(preview).toContainText('R$ 28,90');
  await mkdir('artifacts/pages-screenshots', { recursive: true });
  await page.screenshot({ path: 'artifacts/pages-screenshots/' + info.project.name + '-preview.png',
    fullPage: true, animations: 'disabled' });
  await page.keyboard.press('Escape');
  await expect(preview).toBeHidden();
  const overflow = await page.evaluate(() => document.documentElement.scrollWidth > innerWidth + 2);
  expect(overflow).toBe(false);
  expect(errors).toEqual([]);
});


test('mercado possui exemplos próprios e dados separados do restaurante', async ({ page }, info) => {
  const errors = [];
  page.on('pageerror', e => errors.push(e.message));
  await page.goto('/demo.html?tipo=mercado');
  await expect(page.locator('#store-type')).toHaveValue('mercado');
  await expect(page.locator('#catalog-list')).toContainText('Banana prata 1 kg');
  await expect(page.locator('#catalog-list')).not.toContainText('Hambúrguer da casa');
  await page.getByRole('button', { name: '+ Categoria' }).click();
  await page.locator('#entry-name').fill('Higiene de teste');
  await page.getByRole('button', { name: 'Salvar' }).click();
  await expect(page.locator('#catalog-list')).toContainText('Higiene de teste');
  await page.locator('#store-type').selectOption('restaurante');
  await expect(page.locator('#catalog-list')).toContainText('Hambúrguer da casa');
  await expect(page.locator('#catalog-list')).not.toContainText('Higiene de teste');
  await page.locator('#store-type').selectOption('mercado');
  await expect(page.locator('#catalog-list')).toContainText('Higiene de teste');
  await page.reload();
  await expect(page.locator('#store-type')).toHaveValue('mercado');
  await expect(page.locator('#catalog-list')).toContainText('Higiene de teste');
  const overflow = await page.evaluate(() => document.documentElement.scrollWidth > innerWidth + 2);
  expect(overflow).toBe(false);
  await mkdir('artifacts/pages-screenshots', { recursive: true });
  await page.screenshot({ path: 'artifacts/pages-screenshots/' + info.project.name + '-mercado.png',
    fullPage: true, animations: 'disabled' });
  expect(errors).toEqual([]);
});

test('importação rejeita dados inválidos e permite recuperar o catálogo', async ({ page }) => {
  const errors = [];
  page.on('pageerror', e => errors.push(e.message));
  await page.goto('/demo.html');
  await page.locator('#import-file').setInputFiles({
    name: 'quebrado.json', mimeType: 'application/json',
    buffer: Buffer.from(JSON.stringify({categories:[],products:[{id:'x',categoryId:'inexistente',name:'X',description:'',price:1}]}))
  });
  await expect(page.locator('#demo-feedback')).toContainText('JSON inválido');
  await expect(page.locator('#metric-products')).toHaveText('4');

  const payload = {
    categories: [{id:'import-cat',name:'Categoria importada'}],
    products: [{id:'import-prod',categoryId:'import-cat',name:'Produto importado',description:'Descrição segura',price:12.5}]
  };
  page.once('dialog', dialog => dialog.accept());
  await page.locator('#import-file').setInputFiles({
    name: 'rebbity.json', mimeType: 'application/json',
    buffer: Buffer.from(JSON.stringify(payload))
  });
  await expect(page.locator('#catalog-list')).toContainText('Produto importado');
  await expect(page.locator('#metric-products')).toHaveText('1');
  await page.getByRole('button', { name: 'Desfazer alteração' }).click();
  await expect(page.locator('#catalog-list')).toContainText('Hambúrguer da casa');
  await expect(page.locator('#metric-products')).toHaveText('4');
  expect(errors).toEqual([]);
});

test('exclusão confirmada pode ser desfeita', async ({ page }) => {
  await page.goto('/demo.html');
  const item = page.locator('.product-row').filter({hasText:'Hambúrguer da casa'});
  await expect(item).toHaveCount(1);
  page.once('dialog', dialog => dialog.accept());
  await item.getByRole('button', { name: 'Excluir' }).click();
  await expect(page.locator('#catalog-list')).not.toContainText('Hambúrguer da casa');
  await page.getByRole('button', { name: 'Desfazer alteração' }).click();
  await expect(page.locator('#catalog-list')).toContainText('Hambúrguer da casa');
});
