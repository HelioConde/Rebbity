import { test, expect } from '@playwright/test';

const pages = [
  { label: 'início', query: '' },
  { label: 'restaurante', query: '?pag=restaurant' },
  { label: 'mercado', query: '?pag=market' },
  { label: 'acesso', query: '?pag=acess' },
  { label: 'formulário restaurante', query: '?pag=form-restaurant' },
  { label: 'formulário mercado', query: '?pag=form-market' }
];

for (const route of pages) {
  test(`navegação pública: ${route.label}`, async ({ page }) => {
    await page.goto('/index.html' + route.query);
    const main = page.locator('main');
    await expect(main).not.toBeEmpty();
    await expect(main.locator('.loadError')).toHaveCount(0);
    await expect(main).not.toHaveAttribute('aria-busy', 'true');
  });
}

test('rota desconhecida não tenta acessar arquivos arbitrários', async ({ page }) => {
  const responses = [];
  page.on('request', request => {
    if (request.url().includes('/view/')) responses.push(request.url());
  });
  await page.goto('/index.html?pag=../../config');
  await expect(page.locator('main')).not.toBeEmpty();
  expect(responses.length).toBeGreaterThan(0);
  expect(responses.every(url => url.endsWith('/view/index.html'))).toBe(true);
});

test('foco de teclado aparece na navegação pública', async ({ page }) => {
  await page.goto('/index.html');
  await page.keyboard.press('Tab');
  const skipLink = page.locator('.skip-link');
  await expect(skipLink).toBeFocused();
  const outlineStyle = await skipLink.evaluate(el => getComputedStyle(el).outlineStyle);
  expect(outlineStyle).toBe('solid');
});

test('preferência de movimento reduzido é aplicada', async ({ page }) => {
  await page.emulateMedia({ reducedMotion: 'reduce' });
  await page.goto('/index.html');
  const duration = await page.locator('nav a').first().evaluate(el => getComputedStyle(el).transitionDuration);
  expect(duration.split(',').map(value => parseFloat(value)).every(value => value < 0.01)).toBe(true);
});
