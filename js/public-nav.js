document.addEventListener('DOMContentLoaded', () => {
  const button = document.querySelector('.mobileBar');
  const menu = document.getElementById('public-links');
  if (!button || !menu) return;
  const smallScreen = window.matchMedia('(max-width: 767px)');
  const setOpen = (open, restoreFocus = false) => {
    const active = Boolean(open && smallScreen.matches);
    menu.classList.toggle('rb-nav-open', active);
    button.setAttribute('aria-expanded', String(active));
    button.setAttribute('aria-label', active ? 'Fechar navegação' : 'Abrir navegação');
    if (active) menu.querySelector('a')?.focus();
    else if (restoreFocus) button.focus();
  };
  button.addEventListener('click', () => setOpen(!menu.classList.contains('rb-nav-open'), true));
  menu.addEventListener('click', e => {
    if (e.target.closest('a')) setOpen(false);
  });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && menu.classList.contains('rb-nav-open')) setOpen(false, true);
  });
  smallScreen.addEventListener('change', () => setOpen(false));
});
