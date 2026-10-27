jQuery(function ($) {
  const $toggle = $('#showMobile');
  const $menu = $('#nav nav');
  const mobile = window.matchMedia('(max-width: 767px)');

  function showMenu(open, refocus = false) {
    const active = Boolean(open && mobile.matches);
    $menu.toggleClass('rb-mobile-open', active);
    $toggle.attr('aria-expanded', String(active))
      .attr('aria-label', active ? 'Fechar menu' : 'Abrir menu');
    $('body').toggleClass('rb-menu-open', active);
    if (active) $menu.find('a').first().trigger('focus');
    else if (refocus) $toggle.trigger('focus');
  }

  $toggle.on('click', () => showMenu(!$menu.hasClass('rb-mobile-open'), true));
  $toggle.on('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      $toggle.trigger('click');
    }
  });
  $(document).on('keydown', e => {
    if (e.key === 'Escape' && $menu.hasClass('rb-mobile-open')) showMenu(false, true);
  });
  $menu.on('click', 'a', () => showMenu(false));
  mobile.addEventListener('change', () => showMenu(false));

  // AJAX mutations must report server errors, not silently treat them as success.
  $(document).ajaxError((_event, jqxhr, settings) => {
    if (settings.url?.includes('/csrf.php')) return;
    const text = jqxhr.status === 401 || jqxhr.status === 403
      ? 'Sua sessão expirou ou você não tem permissão para esta ação.'
      : 'Não foi possível concluir a operação. Tente novamente.';
    let $feedback = $('#rb-operation-feedback');
    if (!$feedback.length) {
      $feedback = $('<div id="rb-operation-feedback" role="alert">');
      $('body').append($feedback);
    }
    $feedback.text(text).show();
  });
});
