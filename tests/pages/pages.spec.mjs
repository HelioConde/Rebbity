import { test, expect } from '@playwright/test';
import { mkdir } from 'node:fs/promises';

test('home, navigation and accessibility keyboard menu', async ({ page }, info) => {
  const errors = [];
  page.on('pageerror', error => errors.push(error.message));
  await page.goto('/index.html');
  await expect(page.getByRole('heading', { name: /Organizar sua loja/i })).toBeVisible();
  await expect(page.locator('a[href="./demo.html"]').first()).toBeVisible();
  const overflow = await page.evaluate(() => document.documentElement.scrollWidth > window.innerWidth + 2);
  expect(overflow).toBe(false);
  if (info.project.name === '320px' || info.project.name === '375px') {
    const toggle = page.getByRole('button', { name: 'Abrir menu' });
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
