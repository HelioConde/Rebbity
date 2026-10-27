import { chromium } from '@playwright/test';
import { mkdirSync, readFileSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';

/**
 * Renders transparent favicons and platform touch icons from the same
 * version-controlled SVG. No third-party favicon service or upload needed.
 * Chromium is installed by the Pages CI before npm run build:pages.
 */
export async function renderIconAssets(outDir) {
  const iconDir = join(outDir, 'icons');
  mkdirSync(iconDir, { recursive: true });
  const browser = await chromium.launch({ headless: true });
  try {
    const jobs = [
      { name: 'favicon-16.png', size: 16, src: 'rebbity-mark.svg' },
      { name: 'favicon-32.png', size: 32, src: 'rebbity-mark.svg' },
      { name: 'favicon-192.png', size: 192, src: 'rebbity-mark.svg' },
      { name: 'favicon-512.png', size: 512, src: 'rebbity-mark.svg' },
      { name: 'apple-touch-icon.png', size: 180, src: 'rebbity-mark.svg' },
      { name: 'maskable-512.png', size: 512, src: 'rebbity-maskable.svg' }
    ];
    for (const {name, size, src} of jobs) {
      const svg = readFileSync(join('pages', 'icons', src), 'utf8');
      const page = await browser.newPage({
        viewport: { width: size, height: size }, deviceScaleFactor: 1
      });
      try {
        await page.setContent(
          '<!doctype html><html><head><style>html,body{margin:0;width:100%;height:100%;}' +
          'svg{display:block;width:100%;height:100%}</style></head><body>' +
          svg + '</body></html>'
        );
        await page.locator('svg').screenshot({
          path: join(iconDir, name), omitBackground: true, animations: 'disabled'
        });
      } finally { await page.close(); }
    }
  } finally { await browser.close(); }

  // A modern .ico may contain a PNG frame (Windows Vista+ / Edge / Chrome).
  const png = readFileSync(join(iconDir, 'favicon-32.png'));
  const header = Buffer.alloc(22);
  header.writeUInt16LE(0, 0);  // reserved
  header.writeUInt16LE(1, 2);  // icon resource
  header.writeUInt16LE(1, 4);  // frame count
  header.writeUInt8(32, 6);
  header.writeUInt8(32, 7);
  header.writeUInt8(0, 8);    // palette colors, 0 = full color
  header.writeUInt8(0, 9);
  header.writeUInt16LE(1, 10);
  header.writeUInt16LE(32, 12);
  header.writeUInt32LE(png.length, 14);
  header.writeUInt32LE(22, 18);
  writeFileSync(join(outDir, 'favicon.ico'), Buffer.concat([header, png]));
  console.log('Rendered 6 Rebbity icons and Windows favicon.ico from versioned SVG artwork');
}
