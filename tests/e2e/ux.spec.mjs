import { test, expect } from '@playwright/test';

test('cadastro dividido em etapas preserva respostas e valida CNPJ', async ({ page }) => {
  await page.goto('/index.html?pag=form-restaurant');
  const form = page.locator('#partner-signup');
  await expect(form).toBeVisible();
  await expect(form.locator('.rb-step-status')).toContainText('Etapa 1 de 4');
  await form.locator('[data-action=next]').click();
  await expect(form.locator('.rb-step-status')).toContainText('Etapa 1 de 4');

  await form.locator('[name=cnpj]').fill('11222333000181');
  await form.locator('[name=corporateName]').fill('Teste Ltda');
  await form.locator('[name=name]').fill('Restaurante Teste');
  await form.locator('[name=phone]').fill('61999999999');
  await form.locator('[name=class]').selectOption('restaurant');
  await form.locator('[data-action=next]').click();

  await expect(form.locator('.rb-step-status')).toContainText('Etapa 2 de 4');
  await form.locator('[data-action=back]').click();
  await expect(form.locator('[name=name]')).toHaveValue('Restaurante Teste');
});

test('CNPJ inválido bloqueia mudança de etapa', async ({ page }) => {
  await page.goto('/index.html?pag=form-market');
  const form = page.locator('#partner-signup');
  await expect(form).toBeVisible();
  await form.locator('[name=cnpj]').fill('11111111111111');
  await form.locator('[name=corporateName]').fill('Mercado Teste');
  await form.locator('[name=name]').fill('Mercado Teste');
  await form.locator('[name=phone]').fill('61999999999');
  await form.locator('[name=class]').selectOption('market');
  await form.locator('[data-action=next]').click();
  await expect(form.locator('.rb-step-status')).toContainText('Etapa 1 de 4');
  await expect(form.locator('#rb-form-error')).toBeVisible();
});

test('menu mobile permite abrir e fechar com Escape', async ({ page }, testInfo) => {
  test.skip(testInfo.project.name !== 'mobile-375', 'Somente viewport mobile');
  await page.goto('/index.html');
  const trigger = page.locator('.mobileBar');
  await expect(trigger).toBeVisible();
  await trigger.click();
  await expect(trigger).toHaveAttribute('aria-expanded', 'true');
  await expect(page.locator('#public-links')).toHaveClass(/rb-nav-open/);
  await page.keyboard.press('Escape');
  await expect(trigger).toHaveAttribute('aria-expanded', 'false');
});
