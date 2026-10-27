document.addEventListener('DOMContentLoaded', () => {
  const button = document.querySelector('.nav-toggle');
  const nav = document.getElementById('primary-nav');
  if (button && nav) {
    const setOpen = (next, refocus = false) => {
      const open = Boolean(next);
      nav.classList.toggle('open', open);
      button.setAttribute('aria-expanded', String(open));
      button.setAttribute('aria-label', open ? 'Fechar menu' : 'Abrir menu');
      if (refocus) button.focus();
    };
    button.addEventListener('click', () => setOpen(button.getAttribute('aria-expanded') !== 'true'));
    document.addEventListener('keydown', event => {
      if (event.key === 'Escape' && button.getAttribute('aria-expanded') === 'true') setOpen(false, true);
    });
    nav.addEventListener('click', event => { if (event.target.closest('a')) setOpen(false); });
    window.matchMedia('(min-width: 761px)').addEventListener('change', () => setOpen(false));
  }
  document.querySelectorAll('[data-year]').forEach(element => {
    element.textContent = String(new Date().getFullYear());
  });
});