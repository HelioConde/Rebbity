import { test, expect } from '@playwright/test';
import { mkdir } from 'node:fs/promises';

const pages = [
  { name: 'entrada', query: '' },
  { name: 'restaurante', query: '?pag=restaurant' },
  { name: 'mercado', query: '?pag=market' },
  { name: 'cadastro', query: '?pag=form-restaurant' }
];

for (const item of pages) {
  test('captura visual e largura: ' + item.name, async ({ page }, info) => {
    await page.goto('/index.html' + item.query);
    await expect(page.locator('main')).not.toBeEmpty();
    const overflow = await page.evaluate(() =>
      document.documentElement.scrollWidth > window.innerWidth + 2
    );
    expect(overflow, 'Página não deve exigir rolagem horizontal').toBe(false);
    const directory = 'artifacts/screenshots';
    await mkdir(directory, { recursive: true });
    await page.screenshot({
      path: directory + '/' + info.project.name + '-' + item.name + '.png',
      fullPage: true,
      animations: 'disabled'
    });
  });
}
