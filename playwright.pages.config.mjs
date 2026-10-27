import { defineConfig } from '@playwright/test';

export default defineConfig({
  testDir: './tests/pages',
  timeout: 30_000,
  retries: process.env.CI ? 1 : 0,
  reporter: [['list'], ['html', { open: 'never', outputFolder: 'playwright-report-pages' }]],
  use: { baseURL: 'http://127.0.0.1:8766', trace: 'retain-on-failure', screenshot: 'only-on-failure' },
  projects: [
    { name: '320px', use: { viewport: { width: 320, height: 740 } } },
    { name: '375px', use: { viewport: { width: 375, height: 812 } } },
    { name: '768px', use: { viewport: { width: 768, height: 1024 } } },
    { name: '1366px', use: { viewport: { width: 1366, height: 768 } } },
    { name: '1920px', use: { viewport: { width: 1920, height: 1080 } } }
  ],
  webServer: {
    command: 'python -m http.server 8766 --directory dist-pages --bind 127.0.0.1',
    url: 'http://127.0.0.1:8766/index.html',
    reuseExistingServer: !process.env.CI,
    timeout: 30_000
  }
});
