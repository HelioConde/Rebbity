import { cpSync, mkdirSync, readdirSync, readFileSync, writeFileSync, existsSync, rmSync } from 'node:fs';
import { join } from 'node:path';

const destination = 'dist-pages';
rmSync(destination, { recursive: true, force: true });
mkdirSync(join(destination, 'css'), { recursive: true });
mkdirSync(join(destination, 'js'), { recursive: true });
mkdirSync(join(destination, 'assets'), { recursive: true });

// Whitelist only public static files. Never publish PHP, .env, SQL, or source repositories.
const pages = ['index.html', 'demo.html', 'sobre.html', '404.html'];
const css = ['css/app.css'];
const scripts = ['js/app.js', 'js/demo.js'];
const images = ['logo.png', 'restaurant.png', 'market.png'];
for (const path of [...pages, ...css, ...scripts]) {
  cpSync(join('pages', path), join(destination, path));
}
for (const file of images) cpSync(join('img', file), join(destination, 'assets', file));
writeFileSync(join(destination, '.nojekyll'), '');
const allowed = new Set([...pages, ...css, ...scripts, '.nojekyll', ...images.map(file => 'assets/' + file)]);
const collect = (directory, prefix = '') => {
  for (const entry of readdirSync(directory, { withFileTypes: true })) {
    const relative = (prefix ? prefix + '/' : '') + entry.name;
    if (entry.isDirectory()) collect(join(directory, entry.name), relative);
    else if (!allowed.has(relative)) throw new Error('Disallowed published file: ' + relative);
  }
};
collect(destination);
for (const path of pages) {
  const html = readFileSync(join(destination, path), 'utf8');
  if (/\b(?:action|href|src)\s*=\s*["'][^"']*\.php\b/i.test(html)) {
    throw new Error(path + ' references a PHP endpoint; Pages must be static');
  }
  if (/https?:\/\/[^"'\s]*rebbity\.com/i.test(html)) {
    throw new Error(path + ' references an unverified legacy production domain');
  }
}
const files = [...allowed].sort();
console.log('GitHub Pages public bundle validated (' + files.length + ' files):\n' + files.join('\n'));
